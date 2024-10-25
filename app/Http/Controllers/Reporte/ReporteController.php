<?php

namespace App\Http\Controllers\Reporte;

use App\Enums\TipoReporteEnum;
use App\Http\Controllers\Controller;
use App\Models\Actividades\Actividad;
use App\Models\Reportes\AccionesReporte;
use App\Models\Reportes\EmpleadoAccion;
use App\Models\Reportes\HistorialAccionesReporte;
use App\Models\rhu\Entidades;
use App\Models\Reportes\Reporte;
use Carbon\Carbon;
use Error;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $query = Reporte::query();

        // Filtro por fecha
        if ($request->has('filter-radio')) {
            $filtro = $request->input('filter-radio');

            switch ($filtro) {
                case 'hoy':
                    $query->whereDate('fecha_reporte', today());
                    break;
                case '7_dias':
                    $query->where('fecha_reporte', '>=', now()->subDays(7));
                    break;
                case '30_dias':
                    $query->where('fecha_reporte', '>=', now()->subDays(30));
                    break;
                case 'mes':
                    $query->where('fecha_reporte', '>=', now()->subMonth());
                    break;
                case 'anio':
                    $query->where('fecha_reporte', '>=', now()->subYear());
                    break;
            }
        }

        // Filtro por título (búsqueda por nombre)
        if ($request->has('titulo')) {
            $titulo = $request->input('titulo');
            $query->where('titulo', 'like', '%' . $titulo . '%');
        }

        $reportes = $query->paginate(10);
        // return response()->json([
        //     'status' => 200,
        //     'data' => $reportes
        // ], 200);
        return view('reportes.index', compact('reportes'));
    }

    public function create(Request $request): View
    {
        $validated = $request->validate(
            [
                'actividad' => 'integer|exists:actividades,id',
            ],
            [
                'actividad.exists' => 'La actividad seleccionada no existe'
            ]
        );
        $idActividad = $request->query('actividad');
        $actividad = null;
        if ($idActividad) {
            $actividad = Actividad::findOrFail($idActividad);
        }
        return view('reportes.create', compact('actividad'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'id_aula' => 'integer|exists:aulas,id',
                'id_actividad' => 'integer|exists:actividades,id',
                'tipoReporte' => [Rule::enum(TipoReporteEnum::class)],
                'descripcion' => 'required|string',
                'titulo' => 'required|string|max:50',
            ],
            [
                'id_aula.exists' => 'El aula no existe',
                'id_actividad.exists' => 'La actividad no existe',
                'descripcion.required' => 'Debe ingresar la descripción del reporte',
                'titulo.required' => 'Debe ingresar el titulo del reporte',
            ]
        );
        $reporte = new Reporte();
        $errors = Validator::make([], []);
        if ($request->tipoReporte == 'actividad') {
            if (isset($request->id_actividad)) {
                $reporte->id_actividad = $validated['id_actividad'];
            } else {
                $errors->getMessageBag()->add('id_actividad', 'Debe especificar una actividad');
                throw new ValidationException($errors);
            }
        }
        // He pensado en guardar aqui las aulas relacionadas a la actividad, pero por ahora no xd
        $reporte->id_usuario_reporta = Auth::user()->id;
        $reporte->fecha_reporte = Carbon::now()->format('Y-m-d');
        $reporte->hora_reporte = Carbon::now()->format('H:i:s');
        $reporte->titulo = $validated['titulo'];
        $reporte->descripcion = $validated['descripcion'];
        $reporte->save();

        return redirect()->route('reportes.index')->with('message', [
            'type' => 'success',
            'content' => 'Reporte enviado exitosamente.'
        ]);
    }

    public function detalle(Request $request, $id_reporte)
    {
        $reporte = Reporte::with('aula', 'actividad', 'accionesReporte', 'accionesReporte.entidadAsignada',
            'accionesReporte.usuarioSupervisor', 'usuarioReporta', 'usuarioReporta.persona',
            'empleadosAcciones', 'empleadosAcciones.empleadoPuesto',
            'empleadosAcciones.empleadoPuesto.usuario', 'empleadosAcciones.empleadoPuesto.usuario.persona')->find($id_reporte);
        if (isset($reporte)) {
            $entidades = Entidades::all();
            return response()->json([
                'status' => 200,
                'reporte' => $reporte,
                'entidades' => $entidades
            ], 200);
            return view('reportes.detail', compact('reporte', 'entidades'));
        } else {
            return redirect()->route('reportes.index')->with('message', [
                'type' => 'error',
                'content' => 'El reporte especificado no existe'
            ]);
        }
    }

    public function marcarNoProcede(Request $request, $id_reporte)
    {
        $reporte = Reporte::find($id_reporte);
        if (isset($reporte)) {
            $reporte->no_procede = !$reporte->no_procede;
            $reporte->save();
            return response()->json([
                'message' => 'Reporte actualizado',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Reporte no encontrado',
            ], 404);
        }
    }

    public function realizarAsignacion(Request $request, $id_reporte)
    {
        $validated = $request->validate(
            [
                'id_empleados_puestos' => 'required|array',
                'id_empleados_puestos.*' => 'integer|exists:empleados_puestos,id',
                'comentario' => 'nullable|string',
                'id_entidad' => 'required|integer|exists:entidades,id',
                'id_empleado_supervisor' => 'required|integer|exists:empleados_puestos,id',
            ],
            [
                'id_empleados_puestos.required' => 'Debe asignar al menos un empleado al reporte.',
                'id_empleados_puestos.array' => 'Estructura de empleados asignados inválida.',
                'id_empleados_puestos.*.integer' => 'Cada empleado debe tener un ID válido.',
                'id_empleados_puestos.*.exists' => 'Uno o más empleados seleccionados no existen.',
                'comentario.string' => 'El comentario debe ser un texto válido.',
                'id_entidad.required' => 'Debe seleccionar una entidad.',
                'id_entidad.integer' => 'El ID de la entidad debe ser un número entero.',
                'id_entidad.exists' => 'La entidad seleccionada no existe.',
                'id_empleado_supervisor.required' => 'Debe seleccionar un supervisor para el reporte.',
                'id_empleado_supervisor.integer' => 'El ID del supervsior debe ser un número entero.',
                'id_empleado_supervisor.exists' => 'El empleado supervisor seleccionado no existe.',
            ]
        );
        $reporte = Reporte::find($id_reporte);
        if (isset($reporte)) {
            DB::transaction(function () use ($id_reporte, $validated) {
                    // Registro en ACCIONES_REPORTE
                    $accReporte = new AccionesReporte();
                    $accReporte->id_reporte = $id_reporte;
                    $accReporte->id_usuario_administracion = Auth::user()->id;
                    $accReporte->id_entidad_asignada = $validated['id_entidad'];
                    $accReporte->id_usuario_supervisor = $validated['id_empleado_supervisor'];
                    $accReporte->comentario = $validated['comentario'] ?? '';
                    $accReporte->fecha_asignacion = Carbon::now()->format('Y-m-d');
                    $accReporte->fecha_inicio = Carbon::now()->format('Y-m-d');
                    $accReporte->hora_inicio = Carbon::now()->format('H:i:s');
                    $accReporte->save();
                    // Registro en HISTORIAL_ACCIONES_REPORTES
                    $histAccReporte = new HistorialAccionesReporte();
                    $histAccReporte->id_acciones_reporte = $accReporte->id;
                    $histAccReporte->id_empleado_puesto = Auth::user()->empleadosPuestos->first()->id;
                    $histAccReporte->id_estado = 1;
                    $histAccReporte->fecha_actualizacion = Carbon::now()->format('Y-m-d');
                    $histAccReporte->hora_actualizacion = Carbon::now()->format('H:i:s');
                    $histAccReporte->save();
                    // Registro en EMPLEADOS_ACCIONES
                    foreach ($validated['id_empleados_puestos'] as $emp) {
                        $empAcciones = new EmpleadoAccion();
                        $empAcciones->id_empleado_puesto = $emp;
                        $empAcciones->id_reporte = $id_reporte;
                        $empAcciones->save();
                    }
            });
            return response()->json([
                'message' => 'Reporte asignado con exito',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Reporte no encontrado',
            ], 404);
        }
    }
}
