<?php

namespace App\Http\Controllers\Actividades;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClaseRequest;
use App\Http\Requests\ImportActividadClaseRequest;
use App\Http\Requests\ImportActividadEventoRequest;
use App\Http\Requests\EventoRequest;
use App\Imports\CalendarioImport;
use App\Imports\HorarioImport;
use App\Models\Actividades\Actividad;
use App\Models\Actividades\AulaActividad;
use App\Models\Actividades\Clase;
use App\Models\Actividades\Evento;
use App\Models\General\Dia;
use App\Models\General\Modalidad;
use App\Models\General\TipoClase;
use App\Models\Mantenimientos\Asignatura;
use App\Models\Mantenimientos\Aulas;
use App\Models\Mantenimientos\Ciclo;
use App\Models\Mantenimientos\Escuela;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

use function PHPUnit\Framework\isEmpty;

class ActividadController extends Controller
{
    public function importarActividadesView(Request $request)
    {
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
        if ($request->input('tipo_actividad') == 'evento') {
            $import = new CalendarioImport();
        } else {
            $import = new HorarioImport();
        }
        Excel::import($import, $request->file('excel_file'));
        $data = $import->getData();
        if(empty($data)){
            session()->forget('excelData');
            session()->forget('tipoActividad');
            return redirect()->back()->with('message', [
                'type' => 'warning',
                'content' => 'El archivo no contiene datos para importar o no cumple con el formato.'
            ]);
        }
        session(['excelData' => $data]);
        session(['tipoActividad' => $request->input('tipo_actividad')]);
        return view('actividades.importacion-actividades.importacion-actividades', [
            'excelData' => $data,
            'tipoActividad' => $request->input('tipo_actividad'),
        ]);
    }

    public function eliminarDeSesion($index)
    {
        $excelData = session('excelData', []);
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();

        $indexNuevo = (int)$index;
        $out->writeln(json_encode($indexNuevo));

        // Elimina el registro por índice
        unset($excelData[$indexNuevo]);

        // Reindexa el arreglo y guarda en la sesión
        $excelData = array_values($excelData);
        session(['excelData' => $excelData]);
        if (empty($excelData)) {
            session()->forget('excelData');
            session()->forget('tipoActividad');
        }

        // Redirige de regreso con los datos actualizados
        return redirect()->back()->with('message', [
            'type' => 'info',
            'content' => 'El registro se ha eliminado correctamente.'
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

        Log::info($data);

        foreach ($data['materia'] as $key => $materia) {
            $data['materia'][$key] = Asignatura::where('nombre', $materia)->first()->id;
        }
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
                $actividad->responsable = $data['responsable'][$key];
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
            Log::error($e);
            return redirect()->back()->with('message', [
                'type' => 'error',
                'content' => 'Ocurrió un error al guardar las actividades. Detalles: ' . $e->getMessage()
            ]);
        }
    }

    public function storeEventos(ImportActividadEventoRequest $request)
    {
        $data = $request->all();

        $data['materia'] = array_map('trim', $data['materia']);

        // transforma todas las materias a su correspondiente id de registro independientemente se repitan o no
        foreach ($data['materia'] as $key => $materia) {
            $data['materia'][$key] = Asignatura::where('nombre', $materia)->first()->id;
        }

        $cicloActivo = Ciclo::where('activo', 1)->first();

        try {
            DB::beginTransaction();

            foreach ($data['fecha'] as $key => $fecha) {
                $actividad = new Actividad();
                $actividad->id_ciclo = $cicloActivo->id;
                $actividad->id_modalidad = $data['modalidad'][$key];
                $actividad->hora_inicio = $data['hora_inicio'][$key] ?? null;
                $actividad->hora_fin = $data['hora_fin'][$key] ?? null;
                $actividad->responsable = $data['responsable'][$key];
                $actividad->save();

                if($data['materia'][$key]) {
                    $actividad->asignaturas()->attach($data['materia'][$key]);
                }

                if(isset($data['aulas'][$key])) {
                    $actividad->aulas()->attach($data['aulas'][$key]);
                }

                $evento = new Evento();
                $evento->id_actividad = $actividad->id;
                $evento->descripcion = $data['evaluacion'][$key];
                $evento->fecha = Carbon::createFromFormat('d/m/Y', $fecha)->format('Y-m-d');
                $evento->cantidad_asistentes = $data['cantidad_estudiantes'][$key];
                $evento->comentarios = $data['comentarios'][$key];
                $evento->save();
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
            Log::error($e);
            return redirect()->back()->with('message', [
                'type' => 'error',
                'content' => 'Ocurrió un error al guardar las actividades. Detalles: ' . $e->getMessage()
            ]);
        }
    }

    public function listadoClases(Request $request)
    {
        $materia = $request->input('materia-filtro');
        $escuela = $request->input('escuela-filtro');
        $modalidad = $request->input('modalidad-filtro');
        $tipoClase = $request->input('tipo-filtro');
        $aula = $request->input('aula-filtro');

        $escuelas = Escuela::all()->pluck('nombre', 'id');
        $modalidades = Modalidad::all()->pluck('nombre', 'id');
        $tiposClase = TipoClase::all()->pluck('nombre', 'id');
        $dias = Dia::all();

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
            ->paginate(10)->appends($request->query());

        return view('actividades.listado-actividades.listado-clases', compact('clases', 'escuelas', 'modalidades', 'tiposClase', 'dias'));
    }

    public function storeOneClass(ClaseRequest $request)
    {
        $cicloActivo = Ciclo::where('activo', 1)->first();

        try {
            DB::beginTransaction();

            $actividad = new Actividad();
            $actividad->hora_inicio = $request->input('hora_inicio');
            $actividad->hora_fin = $request->input('hora_fin');
            $actividad->id_modalidad = $request->input('modalidad');
            $actividad->activo = $request->input('estado');
            $actividad->responsable = $request->input('responsable');
            $actividad->id_ciclo = $cicloActivo->id;
            $actividad->save();

            $materia = Asignatura::where('nombre', $request->input('materia'))->first()->id;
            $aula = Aulas::where('nombre', $request->input('local'))->first()->id;

            if($request->input('materia')) {
                $actividad->asignaturas()->attach($materia);
            }

            if($request->input('local') && !empty($request->input('local'))) {
                $actividad->aulas()->attach($aula);
            }

            $clase = new Clase();
            $clase->id_actividad = $actividad->id;
            $clase->id_tipo_clase = $request->input('tipo');
            $clase->numero_grupo = $request->input('grupo');
            $clase->dias_actividad = json_encode($request->input('dias'));
            $clase->save();

            DB::commit();

            return redirect()->back()->with('message', [
                'type' => 'success',
                'content' => 'La clase se ha guardado correctamente.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('message', [
                'type' => 'error',
                'content' => 'Ocurrió un error al guardar la clase. Detalles: ' . $e->getMessage()
            ]);
        }
    }

    public function updateClass(ClaseRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $clase = Clase::find($id);
            $clase->id_tipo_clase = $request->input('tipo');
            $clase->numero_grupo = $request->input('grupo');
            $clase->dias_actividad = json_encode($request->input('dias'));
            $clase->save();

            //actualiza la actividad tamnbien
            $actividad = Actividad::find($clase->id_actividad);
            $actividad->hora_inicio = $request->input('hora_inicio');
            $actividad->hora_fin = $request->input('hora_fin');
            $actividad->id_modalidad = $request->input('modalidad');
            $actividad->responsable = $request->input('responsable');
            $actividad->activo = $request->input('estado');
            $actividad->save();

            //actuliza las aulas y la materia de la actividad
            $actividad->asignaturas()->sync([Asignatura::where('nombre', $request->input('materia'))->first()->id]);
            $actividad->aulas()->sync(Aulas::where('nombre', $request->input('local'))->first()->id);

            DB::commit();

            return redirect()->back()->with('message', [
                'type' => 'success',
                'content' => 'La clase se ha actualizado correctamente.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('message', [
                'type' => 'error',
                'content' => 'Ocurrió un error al actualizar la clase. Detalles: ' . $e->getMessage()
            ]);
        }
    }

    public function listadoEventos(Request $request){
        $escuelas = Escuela::all()->pluck('nombre', 'id');
        $modalidades = Modalidad::all()->pluck('nombre', 'id');
        $tiposClase = TipoClase::all()->pluck('nombre', 'id');
        $aulas = Aulas::all();

        $cicloActivo = Ciclo::where('activo', 1)->first();

        $eventos = Evento::with('actividad', 'actividad.asignaturas.escuela', 'actividad.modalidad', 'actividad.aulas',)
            ->whereHas('actividad', function ($query) use ($cicloActivo) {
                if($cicloActivo){
                    $query->where('id_ciclo', $cicloActivo->id);
                }
            })
            ->when($request->input('descripcion-filter'), function ($query) use ($request) {
                $query->where('descripcion', 'like', "%{$request->input('descripcion-filter')}%");
            })
            ->when($request->input('fecha-filter'), function ($query) use ($request) {
                $query->where('fecha', Carbon::createFromFormat('d/m/Y', $request->input('fecha-filter'))->format('Y-m-d'));
            })
            ->when($request->input('materia-filter'), function ($query) use ($request) {
                $query->whereHas('actividad.asignaturas', function ($query) use ($request) {
                    $query->where('nombre', 'like', "%{$request->input('materia-filter')}%");
                });
            })
            ->when($request->input('modalidad-filter'), function ($query) use ($request) {
                $query->whereHas('actividad', function ($query) use ($request) {
                    $query->where('id_modalidad', $request->input('modalidad-filter'));
                });
            })
            ->when($request->input('aula-filter'), function ($query) use ($request) {
                $query->whereHas('actividad.aulas', function ($query) use ($request) {
                    $query->where('nombre', 'like', "%{$request->input('aula-filter')}%");
                });
            })
            ->paginate(10)->appends($request->query());

        return view('actividades.listado-actividades.listado-eventos-evaluaciones', compact('eventos', 'escuelas', 'modalidades', 'tiposClase', 'aulas'));
    }

    public function storeOneEvent(EventoRequest $request){
        $cicloActivo = Ciclo::where('activo', 1)->first();


        try {
            DB::beginTransaction();

            $actividad = new Actividad();
            $actividad->hora_inicio = $request->input('hora_inicio');
            $actividad->hora_fin = $request->input('hora_fin');
            $actividad->id_modalidad = $request->input('modalidad');
            $actividad->responsable = $request->input('responsable');
            $actividad->activo = $request->input('estado');
            $actividad->id_ciclo = $cicloActivo->id;
            $actividad->save();

            $materia = Asignatura::where('nombre', $request->input('materia'))->first()->id;

            if($request->input('materia')) {
                $actividad->asignaturas()->attach($materia);
            }

            if($request->input('aulas') && !empty($request->input('aulas'))) {
                $actividad->aulas()->attach($request->input('aulas'));

            }

            $evento = new Evento();
            $evento->descripcion = $request->input('evaluacion');
            $evento->fecha = Carbon::createFromFormat('d/m/Y', $request->input('fecha'))->format('Y-m-d');
            $evento->cantidad_asistentes = $request->input('asistentes');
            $evento->comentarios = $request->input('comentario');
            $evento->id_actividad = $actividad->id;
            $evento->save();

            DB::commit();

            return redirect()->back()->with('message', [
                'type' => 'success',
                'content' => 'El evento se ha guardado correctamente.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('message', [
                'type' => 'error',
                'content' => 'Ocurrió un error al guardar el evento. Detalles: ' . $e->getMessage()
            ]);
        }
    }

    public function updateEvent(EventoRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $evento = Evento::find($id);
            $evento->descripcion = $request->input('evaluacion');
            $evento->fecha = Carbon::createFromFormat('d/m/Y', $request->input('fecha'))->format('Y-m-d');
            $evento->cantidad_asistentes = $request->input('asistentes');
            $evento->comentarios = $request->input('comentario');
            $evento->save();

            //actualiza la actividad tamnbien
            $actividad = Actividad::find($evento->id_actividad);
            $actividad->hora_inicio = $request->input('hora_inicio');
            $actividad->hora_fin = $request->input('hora_fin');
            $actividad->id_modalidad = $request->input('modalidad');
            $actividad->responsable = $request->input('responsable');
            $actividad->activo = $request->input('estado');
            $actividad->save();

            //actuliza las aulas y la materia de la actividad
            $actividad->asignaturas()->sync([Asignatura::where('nombre', $request->input('materia'))->first()->id]);
            $actividad->aulas()->sync($request->input('aulas'));

            DB::commit();

            return redirect()->back()->with('message', [
                'type' => 'success',
                'content' => 'El evento se ha actualizado correctamente.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->back()->with('message', [
                'type' => 'error',
                'content' => 'Ocurrió un error al actualizar el evento. Detalles: ' . $e->getMessage()
            ]);
        }
    }
}
