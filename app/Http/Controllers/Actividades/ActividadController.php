<?php

namespace App\Http\Controllers\Actividades;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportActividadClaseRequest;
use App\Http\Requests\ImportActividadEventoRequest;
use App\Imports\CalendarioImport;
use App\Imports\HorarioImport;
use App\Models\Actividades\Actividad;
use App\Models\Actividades\Clase;
use App\Models\General\Modalidad;
use App\Models\General\TipoClase;
use App\Models\Mantenimientos\Asignatura;
use App\Models\Mantenimientos\Aulas;
use App\Models\Mantenimientos\Ciclo;
use App\Models\Mantenimientos\Escuela;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ActividadController extends Controller
{
    public function importarActividadesView(Request $request)
    {
        // Si se presiona el botón "Limpiar datos", olvidar la sesión.
        if (request()->has('clear_session')) {
            session()->forget('excelData');
        }
        return view('actividades.importacion-actividades.importacion-actividades');
    }

    public function importarExcel(Request $request)
    {
        $import = null;
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv',
            'tipo_actividad' => 'required'
        ]);
        // Procesar el archivo Excel y extraer los datos
        if ($request->input('tipo_actividad') == 'evento') {
            $import = new CalendarioImport();
        } else {
            $import = new HorarioImport();
        }
        Excel::import($import, $request->file('excel_file'));

        // Asumamos que el importador guarda los datos importados en una variable
        // $import->getData() obtendrá los datos procesados, este método lo debes crear
        $data = $import->getData();

        if(empty($data)){
            session()->forget('excelData');
            session()->forget('tipoActividad');
            return redirect()->back()->with('message', [
                'type' => 'warning',
                'content' => 'El archivo no contiene datos para importar o no cumple con el formato.'
            ]);
        }

        // Guardamos los datos en la sesión para que se mantengan en caso de errores
        session(['excelData' => $data]);
        session(['tipoActividad' => $request->input('tipo_actividad')]);

        // Regresamos los datos a la vista
        return view('actividades.importacion-actividades.importacion-actividades', [
            'excelData' => $data,
            'tipoActividad' => $request->input('tipo_actividad'),
        ]);
    }

    public function eliminarDeSesion($index)
    {
        $excelData = session('excelData', []);

        // Elimina el registro por índice
        unset($excelData[$index]);

        // Reindexa el arreglo y guarda en la sesión
        $excelData = array_values($excelData);
        session(['excelData' => $excelData]);

        // Redirige de regreso con los datos actualizados
        return redirect()->back()->with('success', 'Registro eliminado correctamente.');
    }

    public function storeClases(ImportActividadClaseRequest $request)
    {
        $data = $request->all();
        $errors = [];
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();

        //verificar longitud del array de materias
        $out->writeln(count($data['materia']));


        // Recorre cada índice de `materia` para verificar que exista un array de días en `diasActividad`
        foreach ($data['materia'] as $key => $materia) {
            if (!isset($data['diasActividad'][$key]) || empty($data['diasActividad'][$key])) {
                // Agrega un mensaje de error específico al array
                $errors["diasActividad.$key"] = "Los días de la actividad en el registro " . ($key + 1) . " son requeridos.";
            }
        }

        // Si existen errores, redirige con los mensajes correspondientes
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        $data['materia'] = Asignatura::whereIn('nombre', $data['materia'])->pluck('id')->toArray();
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln(json_encode($data['materia']));
        $data['local'] = Aulas::whereIn('nombre', $data['local'])->pluck('id')->toArray();

        $cicloActivo = Ciclo::where('activo', 1)->first();

        try{
            DB::beginTransaction();

            foreach ($data['modalidad'] as $key => $modalidad) {
                $actividad = new Actividad();
                $actividad->id_ciclo = $cicloActivo->id;
                $actividad->id_modalidad = $data['modalidad'][$key];
                $actividad->hora_inicio = $data['hora_inicio'][$key];
                $actividad->hora_fin = $data['hora_fin'][$key];
                $actividad->save();

                $actividad->asignaturas()->attach($data['materia'][$key]);
                $actividad->aulas()->attach($data['local'][$key]);

                $clase = new Clase();
                $clase->id_actividad = $actividad->id;
                $clase->id_tipo_clase = $data['tipo'][$key];
                $clase->numero_grupo = $data['grupo'][$key];
                $clase->dias_actividad = json_encode($data['diasActividad'][$key]);
                $clase->save();

            }

            DB::commit();

            session()->forget('excelData');
            session()->forget('tipoActividad');

            return redirect()->back()->with('message', [
                'type' => 'success',
                'content' => 'Las actividades se han guardado correctamente.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('message', [
                'type' => 'error',
                'content' => 'Ocurrió un error al guardar las actividades. Detalles: ' . $e->getMessage()
            ]);
        }
    }

    public function storeEventos(ImportActividadEventoRequest $request)
    {
        $data = $request->all();
        $errors = [];

        $data['materia'] = Asignatura::whereIn('nombre', $data['materia'])->pluck('id')->toArray();

        dd($request->all());
    }

    public function listadoClases(Request $request)
    {
        $materia = $request->input('materia');
        $escuela = $request->input('escuela');
        $modalidad = $request->input('modalidad');
        $tipoClase = $request->input('tipo');
        $aula = $request->input('aula');

        $escuelas = Escuela::all()->pluck('nombre', 'id');
        $modalidades = Modalidad::all()->pluck('nombre', 'id');
        $tiposClase = TipoClase::all()->pluck('nombre', 'id');

        $cicloActivo = Ciclo::where('activo', 1)->first();
        $clases = Clase::with('actividad', 'actividad.asignaturas.escuela', 'actividad.modalidad', 'actividad.aulas', 'tipoClase')
            ->whereHas('actividad', function ($query) use ($cicloActivo) {
                if($cicloActivo){
                    $query->where('id_ciclo', $cicloActivo->id);
                }
            })
            ->when($materia, function ($query, $materia) {
                $query->whereHas('actividad.asignaturas', function ($query) use ($materia) {
                    $query->where('nombre', 'like', "%$materia%");
                });
            })
            ->when($escuela, function ($query, $escuela) {
                $query->whereHas('actividad.asignaturas', function ($query) use ($escuela) {
                    $query->where('id_escuela', $escuela);
                });
            })
            ->when($modalidad, function ($query, $modalidad) {
                $query->whereHas('actividad', function ($query) use ($modalidad) {
                    $query->where('id_modalidad', $modalidad);
                });
            })
            ->when($tipoClase, function ($query, $tipoClase) {
                $query->where('id_tipo_clase', $tipoClase);
            })
            ->when($aula, function ($query, $aula) {
                $query->whereHas('actividad.aulas', function ($query) use ($aula) {
                    $query->where('nombre', 'like', "%$aula%");
                });
            })
            ->paginate(10);

        return view('actividades.listado-actividades.listado-clases', compact('clases', 'escuelas', 'modalidades', 'tiposClase'));
    }
}
