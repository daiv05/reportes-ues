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
use App\Models\Mantenimientos\Aulas;
use App\Models\Reportes\RecursoReporte;
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
        $aulas = Aulas::all(); // Obtener todas las aulas
        return view('reportes.create', compact('actividad', 'aulas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'id_aula' => 'nullable|integer|exists:aulas,id',
                'descripcion' => 'required|string',
                'titulo' => 'required|string|max:50',
            ],
            [
                'id_aula.exists' => 'El aula no existe',
                'descripcion.required' => 'Debe ingresar la descripción del reporte',
                'titulo.required' => 'Debe ingresar el titulo del reporte',
            ]
        );

        $reporte = new Reporte();
        $reporte->id_usuario_reporta = Auth::user()->id;
        $reporte->fecha_reporte = Carbon::now()->format('Y-m-d');
        $reporte->hora_reporte = Carbon::now()->format('H:i:s');
        $reporte->titulo = $validated['titulo'];
        $reporte->descripcion = $validated['descripcion'];
        $reporte->id_aula = $validated['id_aula'] ?? null; // Asignar null si no se seleccionó aula

        $reporte->save();

        return redirect()->route('reportes-generales')->with('message', [
            'type' => 'success',
            'content' => 'Reporte enviado exitosamente.'
        ]);
    }

    public function detalle(Request $request, $id_reporte)
    {
        $reporte = Reporte::with(
            'aula',
            'actividad',
            'accionesReporte',
            'accionesReporte.entidadAsignada',
            'accionesReporte.usuarioSupervisor',
            'accionesReporte.usuarioSupervisor.persona',
            'usuarioReporta',
            'usuarioReporta.persona',
            'empleadosAcciones',
            'empleadosAcciones.empleadoPuesto',
            'empleadosAcciones.empleadoPuesto.usuario',
            'empleadosAcciones.empleadoPuesto.usuario.persona'
        )->find($id_reporte);
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
        try {
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
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
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

    public function actualizarEstadoReporte(Request $request, $id_reporte)
    {
        $request->validate(
            [
                'comentario' => 'required|string',
                'id_estado' => 'required|integer|exists:estados,id',
                'evidencia' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
                'recursos' => 'nullable|array',
                'recursos.*.nombre' => 'required|string|max:100',
                'recursos.*.costo' => 'required|numeric|min:0',
            ],
            [
                'recursos.array' => 'Estructura de recursos utilizados inválida.',
                'recursos.*.nombre.required' => 'Debe especificar un nombre de recurso válido.',
                'recursos.*.nombre.string' => 'Debe especificar un nombre de recurso válido.',
                'recursos.*.nombre.max' => 'El nombre del recurso no debe exceder los 50 caracteres',
                'recursos.*.costo.required' => 'Debe especificar un nombre de recurso válido.',
                'recursos.*.costo.numeric' => 'Debe especificar un nombre de recurso válido.',
                'recursos.*.costo.min' => 'El costo del recurso no puede ser menor a cero.',
                'comentario.required' => 'Debe especificar las acciones realizadas.',
                'comentario.string' => 'El comentario debe ser un texto válido.',
                'evidencia.image' => 'La evidencia debe ser un archivo de imagen.',
                'evidencia.mimes' => 'La evidencia debe ser una imagen de tipo: png, jp o jpeg.',
                'id_estado.required' => 'Debe seleccionar un estado para actualizar el reporte.',
                'id_estado.integer' => 'El ID del estado debe ser un número entero.',
                'id_estado.exists' => 'El estado seleccionado no existe.',
            ]
        );
        $reporte = Reporte::find($id_reporte);
        if (!isset($reporte)) {
            return response()->json([
                'message' => 'Reporte no encontrado',
            ], 404);
        }
        $accionReporte = $reporte->accionesReporte;
        if (!isset($accionReporte)) {
            return response()->json([
                'message' => 'El reporte no tiene ninguna asignación',
            ], 404);
        }
        $empleadoAcciones = $reporte->empleadosAcciones;
        $puestosEmpleado = Auth::user()->empleadosPuestos;
        $puestosEmpleadoIds = $puestosEmpleado->pluck('id')->toArray();
        $empleadoPuestoAccion = $empleadoAcciones->firstWhere(fn($accion) => in_array($accion->id_empleado_puesto, $puestosEmpleadoIds));
        if (!isset($empleadoPuestoAccion)) {
            return response()->json([
                'message' => 'No tienes permiso para actualizar este reporte',
            ], 403);
        }

        DB::transaction(function () use ($request, $empleadoPuestoAccion, $accionReporte) {
            $newHistorialAccionesReportes = new HistorialAccionesReporte();
            $newHistorialAccionesReportes->id_acciones_reporte = $accionReporte->id;
            $newHistorialAccionesReportes->id_empleado_puesto = $empleadoPuestoAccion->id_empleado_puesto;
            $newHistorialAccionesReportes->id_estado = $request['id_estado'];
            $newHistorialAccionesReportes->fecha_actualizacion = Carbon::now()->format('Y-m-d');
            $newHistorialAccionesReportes->hora_actualizacion = Carbon::now()->format('H:i:s');
            $newHistorialAccionesReportes->comentario = $request['comentario'];
            // Guardar evidencia en el storage
            $path = $request->file('image')->store('public/reportes/evidencia');
            $newHistorialAccionesReportes->foto_evidencia = $path;
            $newHistorialAccionesReportes->save();
            // Guardar recursos
            foreach ($request->recursos as $recurso) {
                RecursoReporte::create([
                    'id_historial_acciones_reporte ' => $newHistorialAccionesReportes->id,
                    'nombre' => $recurso['nombre'],
                    'costo' => $recurso['costo'],
                ]);
            }
        });

        return response()->json([
            'message' => 'Seguimiento de reporte actualizado con exito',
        ], 200);
    }
}
