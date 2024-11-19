<?php

namespace App\Http\Controllers\Actividades;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportActividadClaseRequest;
use App\Http\Requests\ImportActividadEventoRequest;
use App\Imports\CalendarioImport;
use App\Imports\HorarioImport;
use App\Models\Actividades\Actividad;
use App\Models\Actividades\Clase;
use App\Models\Mantenimientos\Asignatura;
use App\Models\Mantenimientos\Aulas;
use App\Models\Mantenimientos\Ciclo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ActividadController extends Controller
{
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

    public function storeClases(ImportActividadClaseRequest $request)
    {
        $data = $request->all();
        $errors = [];

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
        $data['local'] = Aulas::whereIn('nombre', $data['local'])->pluck('id')->toArray();

        $cicloActivo = Ciclo::where('activo', 1)->first();

        try{
            DB::beginTransaction();

            foreach ($data['modalidad'] as $key => $materia) {
                $actividad = new Actividad();
                $actividad->id_ciclo = $cicloActivo->id;
                $actividad->id_modalidad = $data['modalidad'][$key];
                $actividad->hora_inicio = $data['hora_inicio'][$key];
                $actividad->hora_fin = $data['hora_fin'][$key];
                $actividad->save();

                $actividad->asignaturas()->attach($materia);
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
        $search = $request->input('table-search');
        $cicloActivo = Ciclo::where('activo', 1)->first();
        $clases = Clase::with('actividad', 'actividad.asignaturas.escuela', 'actividad.modalidad', 'actividad.aulas', 'tipoClase')
            ->whereHas('actividad', function ($query) use ($cicloActivo) {
                if($cicloActivo){
                    $query->where('id_ciclo', $cicloActivo->id);
                }
            })
            ->when($search, function ($query, $search) {
                $query->whereHas('actividad.asignaturas', function ($query) use ($search) {
                    $query->where('nombre', 'like', "%$search%");
                });
            })
            ->paginate(10);

        return view('actividades.listado-actividades.listado-clases', compact('clases'));
    }
}
