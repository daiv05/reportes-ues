<?php

namespace App\Http\Controllers\Reporte;

use App\Enums\EstadosEnum;
use App\Enums\GeneralEnum;
use App\Http\Controllers\Controller;
use App\Http\Controllers\rhu\EmpleadoPuestoController;
use App\Mail\ReporteMailable;
use App\Models\Actividades\Clase;
use App\Models\Actividades\Evento;
use App\Models\Reportes\AccionesReporte;
use App\Models\Reportes\EmpleadoAccion;
use App\Models\Reportes\HistorialAccionesReporte;
use App\Models\rhu\Entidades;
use App\Models\Reportes\Reporte;
use App\Models\Mantenimientos\Aulas;
use App\Models\Mantenimientos\Recurso;
use App\Models\Reportes\Estado;
use App\Models\Reportes\RecursoReporte;
use App\Models\Reportes\ReporteBien;
use App\Models\Reportes\ReporteEvidencia;
use App\Models\rhu\EmpleadoPuesto;
use App\Models\Seguridad\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $query = Reporte::query();
        $this->filtrosGenerales($request, $query);
        $reportes = $query->paginate(GeneralEnum::PAGINACION->value)->appends($request->query());
        return view('reportes.index', compact('reportes'));
    }

    public function indexMisReportes(Request $request)
    {
        $query = Reporte::query();
        $query->where('id_usuario_reporta', Auth::user()->id);
        $this->filtrosGenerales($request, $query);
        $reportes = $query->paginate(GeneralEnum::PAGINACION->value)->appends($request->query());
        return view('reportes.my-reports', compact('reportes'));
    }

    public function misAsignaciones(Request $request)
    {
        $idUsuario = Auth::user()->id;
        $query = Reporte::query();
        $query->whereHas('accionesReporte.usuarioSupervisor', function ($query) use ($idUsuario) {
            $query->where('id', $idUsuario);
        })->orWhereHas('empleadosAcciones', function ($query) use ($idUsuario) {
            $query->whereHas('empleadoPuesto.usuario', function ($query) use ($idUsuario) {
                $query->where('id', $idUsuario);
            });
        });
        $this->filtrosGenerales($request, $query);
        $reportes = $query->paginate(GeneralEnum::PAGINACION->value)->appends($request->query());
        return view('reportes.my-assignments', compact('reportes'));
    }

    public function create(Request $request)
    {
        $idActividadEvento = $request['evento'];
        $idActividadClase = $request['clase'];
        $clase = null;
        $evento = null;
        if ($idActividadEvento) {
            $evento = Evento::where('id_actividad', $idActividadEvento)->first();
            if (!isset($evento)) {
                Session::flash('message', [
                    'type' => 'error',
                    'content' => 'La actividad seleccionada no existe'
                ]);
                return redirect()->action([ReporteController::class, 'index']);
            }
        }
        if ($idActividadClase) {
            $clase = Clase::where('id_actividad', $idActividadClase)->first();
            if (!isset($clase)) {
                Session::flash('message', [
                    'type' => 'error',
                    'content' => 'La actividad seleccionada no existe'
                ]);
                return redirect()->action([ReporteController::class, 'index']);
            }
        }
        $aulas = Aulas::where('activo', true)->get();
        return view('reportes.create', compact('clase', 'evento', 'aulas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'id_aula' => 'nullable|integer|exists:aulas,id',
                'id_actividad' => 'nullable|integer|exists:actividades,id',
                'descripcion' => 'required|string|max:255|regex:/^[a-zA-Z0-9.,ñÑáéíóúÁÉÍÓÚüÜ_\- ]+$/',
                'titulo' => 'required|string|max:50|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ ]+$/',
                'comprobantes' => 'nullable|array|max:5',
                'comprobantes.*' => 'required|image|mimes:png,jpg,jpeg|max:10240',
            ],
            [
                'id_aula.exists' => 'El aula no existe',
                'id_actividad.exists' => 'La actividad no existe',
                'descripcion.required' => 'La descripción es obligatoria',
                'descripcion.string' => 'La descripción debe ser un texto válido',
                'descripcion.max' => 'La descripción no debe exceder los 255 caracteres',
                'titulo.required' => 'Debe ingresar un titulo para el reporte',
                'titulo.max' => 'El titulo no debe exceder los 50 caracteres',
                'titulo.regex' => 'El titulo solo puede contener letras, números y espacios',
                'descripcion.string' => 'La descripción debe ser un texto válido',
                'descripcion.regex' => 'La descripción solo puede contener letras, números, espacios y guiones',
                'comprobantes.array' => 'Estructura de comprobantes inválida',
                'comprobantes.*.required' => 'Debe adjuntar una imagen',
                'comprobantes.*.image' => 'El comprobante adjuntado debe ser una imagen válida',
                'comprobantes.*.mimes' => 'Los comprobantes solo pueden ser: png, jpg o jpeg',
                'comprobantes.*.max' => 'Cada imagen de comprobante no debe exceder los 10MB',
            ]
        );

        $reporte = new Reporte();
        $reporte->id_usuario_reporta = Auth::user()->id;
        $reporte->fecha_reporte = Carbon::now()->format('Y-m-d');
        $reporte->hora_reporte = Carbon::now()->format('H:i:s');
        $reporte->titulo = $validated['titulo'];
        $reporte->descripcion = $validated['descripcion'];
        $reporte->id_aula = $validated['id_aula'] ?? null; // Asignar null si no se seleccionó aula
        $reporte->id_actividad = $validated['id_actividad'] ?? null; // Asignar null si no se seleccionó aula

        $reporte->save();

        // Guardar evidencias
        if ($request->hasFile('comprobantes')) {
            foreach ($request->file('comprobantes') as $evidencia) {
                $fileName = Str::random(40);
                $path = $evidencia->storeAs(
                    "reportes/comprobante",
                    $fileName . "." . $evidencia->getClientOriginalExtension(),
                    'public'
                );
                $reporteEvidencia = new ReporteEvidencia();
                $reporteEvidencia->id_reporte = $reporte->id;
                $reporteEvidencia->ruta = $path;
                $reporteEvidencia->save();
            }
        }

        return redirect()->route('reportes-generales')->with('message', [
            'type' => 'success',
            'content' => 'Reporte enviado exitosamente.'
        ]);
    }

    public function detalle(Request $request, $id_reporte)
    {
        $infoReporte = $this->infoDetalleReporte($request, $id_reporte);
        if (isset($infoReporte['reporte'])) {
            return view('reportes.detail', array_merge($infoReporte));
        } else {
            Session::flash('message', [
                'type' => 'error',
                'content' => 'El reporte especificado no existe'
            ]);
            return redirect()->route('reportes-generales');
        }
    }

    public function verInforme($id_reporte)
    {
        $reporte = Reporte::find($id_reporte);

        if (isset($reporte)) {
            // Obtener fondos y recursos
            $fondos = DB::table('fondos')->get();
            $recursos = DB::table('recursos')->get();

            // Calcular la duración del reporte
            $fechaCreacion = \Carbon\Carbon::parse($reporte->fecha_reporte);
            $fechaFinalizacion = $reporte->accionesReporte->historialAccionesReporte
                ->where('estado.id', EstadosEnum::FINALIZADO->value)
                ->first()
                ->created_at ?? null;

            $duracion = $fechaFinalizacion ? $fechaCreacion->diff($fechaFinalizacion)->format('%m meses, %d días, %h horas, %i minutos') : 'En progreso';

            // Obtener recursos usados
            $recursosUsados = RecursoReporte::whereHas('historialAccionesReporte', function ($query) use ($reporte) {
                $query->where('id_acciones_reporte', $reporte->accionesReporte->id);
            })->get();

            // Obtener datos adicionales
            $entidad = $reporte->accionesReporte->entidadAsignada;
            $subalternos = $reporte->empleadosAcciones;
            $supervisor = $reporte->accionesReporte->usuarioSupervisor;
            $comentarioSupervisor = $reporte->accionesReporte->comentario_supervisor;

            return view('reportes.ver-informe', [
                'reporte' => $reporte,
                'fondos' => $fondos,
                'recursos' => $recursos,
                'duracion' => $duracion,
                'recursosUsados' => $recursosUsados,
                'entidad' => $entidad,
                'subalternos' => $subalternos,
                'supervisor' => $supervisor,
                'comentarioSupervisor' => $comentarioSupervisor
            ]);
        } else {
            return redirect()->route('reportes.index')->with('message', [
                'type' => 'error',
                'content' => 'Reporte no encontrado'
            ]);
        }
    }

    public function marcarNoProcede(Request $request, $id_reporte): RedirectResponse
    {
        $reporte = Reporte::find($id_reporte);
        if (isset($reporte)) {
            $reporte->no_procede = !$reporte->no_procede;
            $reporte->save();
            Session::flash('message', [
                'type' => 'success',
                'content' => 'Reporte actualizado'
            ]);
            return redirect()->action([ReporteController::class, 'detalle'], ['id' => $reporte->id]);
        } else {
            Session::flash('message', [
                'type' => 'error',
                'content' => 'Reporte no encontrado'
            ]);
            return redirect()->action([ReporteController::class, 'detalle'], ['id' => $reporte->id]);
        }
    }

    public function realizarAsignacion(Request $request, $id_reporte): RedirectResponse
    {
        // Convertir la cadena de texto separada por comas en un arreglo solo si no está vacía
        $idEmpleadosPuestos = $request->input('id_empleados_puestos');
        if (!empty($idEmpleadosPuestos)) {
            $request->merge([
                'id_empleados_puestos' => explode(',', $idEmpleadosPuestos)
            ]);
        } else {
            $request->merge([
                'id_empleados_puestos' => []
            ]);
        }
        $idBienes = $request->input('id_bienes');
        if (!is_array($idBienes)) {
            $idBienes = json_decode($idBienes, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $idBienes = explode(',', $idBienes);
            }
            $request->merge(['id_bienes' => $idBienes]);
        }

        $validated = $request->validate(
            [
                'id_empleados_puestos' => 'required|array',
                'id_empleados_puestos.*' => 'integer|exists:empleados_puestos,id',
                'comentario' => 'nullable|string|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\- ]+$/',
                'id_entidad' => 'required|integer|exists:entidades,id',
                'id_empleado_supervisor' => 'required|integer|exists:empleados_puestos,id',
                'id_bienes' => 'array',
                'id_bienes.*' => 'integer|exists:bienes,id',
                'id_categoria_reporte' => 'required|integer|exists:categoria_reportes,id',
            ],
            [
                'id_empleados_puestos.required' => 'Debe asignar al menos un empleado al reporte.',
                'id_empleados_puestos.array' => 'Estructura de empleados asignados inválida.',
                'id_empleados_puestos.*.integer' => 'Cada empleado debe tener un ID válido.',
                'id_empleados_puestos.*.exists' => 'Uno o más empleados seleccionados no existen.',
                'comentario.string' => 'El comentario debe ser un texto válido.',
                'comentario.regex' => 'El comentario solo puede contener letras, números, espacios y guiones',
                'id_entidad.required' => 'Debe seleccionar una entidad.',
                'id_entidad.integer' => 'El ID de la entidad debe ser un número entero.',
                'id_entidad.exists' => 'La entidad seleccionada no existe.',
                'id_empleado_supervisor.required' => 'Debe seleccionar un supervisor para el reporte.',
                'id_empleado_supervisor.integer' => 'El ID del supervisor debe ser un número entero.',
                'id_empleado_supervisor.exists' => 'El empleado supervisor seleccionado no existe.',
                'id_bienes.array' => 'Estructura de bienes asignados inválida.',
                'id_bienes.*.integer' => 'Cada bien debe tener un ID válido.',
                'id_bienes.*.exists' => 'Uno o más bienes seleccionados no existen.',
                'id_categoria_reporte.required' => 'Debe asignar una categoría al reporte.',
                'id_categoria_reporte.integer' => 'El ID de la categoría de reporte debe ser un número entero.',
                'id_categoria_reporte.exists' => 'La categoría de reporte seleccionada no existe.',
            ]
        );

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
            $accReporte->id_categoria_reporte = $validated['id_categoria_reporte'] ?? 1;
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

            if ($validated['id_bienes']) {
                // Registro en REPORTE_BIENES
                foreach ($validated['id_bienes'] as $bien) {
                    $repBien = new ReporteBien();
                    $repBien->id_bien = $bien;
                    $repBien->id_reporte = $id_reporte;
                    $repBien->save();
                }
            }
        });

        // Envio de correos a subalternos y supervisor
        $reporte = Reporte::find($id_reporte);
        $tableData = [
            'reporte' => $reporte,
            'esSupervisor' => false,
        ];
        foreach ($validated['id_empleados_puestos'] as $emp) {
            $empPuesto = EmpleadoPuesto::find($emp)->usuario->email;
            Mail::to($empPuesto)->send(new ReporteMailable('emails.asignacion', $tableData, 'Asignación de reporte'));
        }
        $tableData = [
            'reporte' => $reporte,
            'esSupervisor' => true,
        ];
        $empSupervisor = User::find($validated['id_empleado_supervisor'])->email;
        Mail::to($empSupervisor)->send(new ReporteMailable('emails.asignacion', $tableData, 'Asignación de reporte'));

        Session::flash('message', [
            'type' => 'success',
            'content' => 'Requerimiento asignado exitosamente'
        ]);
        return redirect()->action([ReporteController::class, 'detalle'], ['id' => $reporte->id]);
    }

    public function actualizarEstadoReporte(Request $request, $id_reporte): RedirectResponse
    {
        $requestRecursos = $request->input('recursos');
        if (!empty($requestRecursos)) {
            $request->merge([
                'recursos' => json_decode($requestRecursos, true)
            ]);
        } else {
            $request->merge([
                'recursos' => []
            ]);
        }

        $request->validate(
            [
                'comentario' => 'required|string|max:100|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ ]+$/',
                'id_estado' => 'required|integer|exists:estados,id',
                'evidencia' => 'nullable|image|mimes:png,jpg,jpeg|max:10240',
                'recursos' => 'nullable|array',
                'recursos.*.cantidad' => 'required|integer|max:100',
                'recursos.*.id_fondo' => 'required|integer|exists:fondos,id',
                'recursos.*.id_recurso' => 'required|integer|exists:recursos,id',
                'recursos.*.id_unidad_medida' => 'required|integer|exists:unidades_medida,id',
            ],
            [
                'recursos.array' => 'Estructura de recursos utilizados inválida.',
                'recursos.*.cantidad.required' => 'Debe especificar la cantidad de recurso utilizado',
                'recursos.*.cantidad.integer' => 'La cantidad de recurso debe ser un número entero.',
                'recursos.*.cantidad.max' => 'La cantidad de recurso no puede ser mayor a 100.',
                'recursos.*.id_fondo.required' => 'Debe especificar de que fondo proviene el recurso',
                'recursos.*.id_fondo.integer' => 'El identificador del fondo debe ser un número entero',
                'recursos.*.id_fondo.exists' => 'Fondo no encontrado',
                'recursos.*.id_recurso.required' => 'Debe especificar el recurso utilizado',
                'recursos.*.id_recurso.integer' => 'El identificador del recurso debe ser un número entero',
                'recursos.*.id_recurso.exists' => 'Recurso no encontrado',
                'recursos.*.id_unidad_medida.required' => 'Debe especificar una unidad de medida',
                'recursos.*.id_unidad_medida.integer' => 'El identificador de la unidad debe ser un número entero',
                'recursos.*.id_unidad_medida.exists' => 'Unidad de medida no encontrada',
                'comentario.required' => 'Debe especificar las acciones realizadas.',
                'comentario.string' => 'El comentario debe ser un texto válido.',
                'comentario.max' => 'El comentario no debe exceder los 100 caracteres.',
                'comentario.regex' => 'El comentario solo puede contener letras, números y espacios.',
                'evidencia.image' => 'La evidencia debe ser un archivo de imagen.',
                'evidencia.mimes' => 'La evidencia debe ser una imagen de tipo: png, jpg o jpeg.',
                'evidencia.max' => 'La evidencia no debe exceder los 10MB.',
                'id_estado.required' => 'Debe seleccionar un estado para actualizar el reporte.',
                'id_estado.integer' => 'El ID del estado debe ser un número entero.',
                'id_estado.exists' => 'El estado seleccionado no existe.',
            ]
        );
        $reporte = Reporte::find($id_reporte);
        $accionReporte = $reporte->accionesReporte;
        if (!isset($accionReporte)) {
            Session::flash('message', [
                'type' => 'error',
                'content' => 'El reporte especificado no existe'
            ]);
            return redirect()->action([ReporteController::class, 'detalle'], ['id' => $reporte->id]);
        }
        $empleadoAcciones = $reporte->empleadosAcciones;
        $puestosEmpleado = Auth::user()->empleadosPuestos;
        $puestosEmpleadoIds = $puestosEmpleado->pluck('id')->toArray();
        $empleadoPuestoAccion = $empleadoAcciones->firstWhere(fn($accion) => in_array($accion->id_empleado_puesto, $puestosEmpleadoIds));
        $esSupervisor = $accionReporte->id_usuario_supervisor === Auth::user()->id;
        $idEmpleado = null;
        if (isset($empleadoPuestoAccion)) {
            if (in_array($request['id_estado'], [EstadosEnum::FINALIZADO->value, EstadosEnum::INCOMPLETO->value])) {
                if ($esSupervisor) {
                    $idEmpleado = Auth::user()->empleadosPuestos->first()->id;
                } else {
                    Session::flash('message', [
                        'type' => 'error',
                        'content' => 'No tienes permiso para actualizar a este estado'
                    ]);
                    return redirect()->action([ReporteController::class, 'detalle'], ['id' => $reporte->id]);
                }
            } else {
                $idEmpleado = $empleadoPuestoAccion->id_empleado_puesto;
            }
        } else if ($esSupervisor) {
            if (in_array($request['id_estado'], [EstadosEnum::FINALIZADO->value, EstadosEnum::INCOMPLETO->value])) {
                $idEmpleado = Auth::user()->empleadosPuestos->first()->id;
            } else {
                Session::flash('message', [
                    'type' => 'error',
                    'content' => 'No tienes permiso para actualizar a este estado'
                ]);
                return redirect()->action([ReporteController::class, 'detalle'], ['id' => $reporte->id]);
            }
        } else {
            Session::flash('message', [
                'type' => 'error',
                'content' => 'No tienes permiso para actualizar este reporte'
            ]);
            return redirect()->action([ReporteController::class, 'detalle'], ['id' => $reporte->id]);
        }

        try {
            $esFinalizado = $request['id_estado'] == EstadosEnum::FINALIZADO->value;
            $esIncompleto = $request['id_estado'] == EstadosEnum::INCOMPLETO->value;
            // Guardar empleado en historial segun si es supervisor o empleado
            DB::transaction(function () use ($request, $idEmpleado, $accionReporte, $esFinalizado) {
                $newHistorialAccionesReportes = new HistorialAccionesReporte();
                $newHistorialAccionesReportes->id_acciones_reporte = $accionReporte->id;
                $newHistorialAccionesReportes->id_empleado_puesto = $idEmpleado;
                $newHistorialAccionesReportes->id_estado = $request['id_estado'];
                $newHistorialAccionesReportes->fecha_actualizacion = Carbon::now()->format('Y-m-d');
                $newHistorialAccionesReportes->hora_actualizacion = Carbon::now()->format('H:i:s');
                $newHistorialAccionesReportes->comentario = $request['comentario'];
                // Guardar evidencia en el storage
                if ($request->file('evidencia')) {
                    $fileName = Str::random(40);
                    $path = $request->file('evidencia')->storeAs(
                        "reportes/evidencia",
                        $fileName . "." . $request->file('evidencia')->getClientOriginalExtension(),
                        'public'
                    );
                    $newHistorialAccionesReportes->foto_evidencia = $path;
                }
                $newHistorialAccionesReportes->save();
                // Guardar recursos
                if (isset($request->recursos)) {
                    foreach ($request->input('recursos', []) as $recurso) {
                        RecursoReporte::create([
                            'id_historial_acciones_reporte' => $newHistorialAccionesReportes->id,
                            'cantidad' => $recurso['cantidad'],
                            'id_fondo' => $recurso['id_fondo'],
                            'id_recurso' => $recurso['id_recurso'],
                            'id_unidad_medida' => $recurso['id_unidad_medida'],
                            'comentario' => $request->get('comentario', ''),
                        ]);
                    }
                }
                // Verificar si el reporte ya se marcó como FINALIZADO
                if ($esFinalizado) {
                    $accionReporte->fecha_finalizacion = Carbon::now()->format('Y-m-d');
                    $accionReporte->hora_finalizacion = Carbon::now()->format('H:i:s');
                    $accionReporte->save();
                }
            });

            $reporte = Reporte::find($id_reporte);
            $tableData = [
                'reporte' => $reporte
            ];
            if ($esFinalizado || $esIncompleto) {
                // Envio de correos a SUBALTERNOS cuando SUPERVISOR envie resolucion (FINALIZADO o INCOMPLETO)
                foreach ($puestosEmpleadoIds as $emp) {
                    $empPuesto = EmpleadoPuesto::find($emp)->usuario->email;
                    $subject = '';
                    $esFinalizado ? $subject = 'Reporte FINALIZADO' : $subject = 'Reporte INCOMPLETO';
                    Mail::to($empPuesto)->send(new ReporteMailable('emails.supervisor-revision', $tableData, $subject));
                }
            } else if ($request['id_estado'] == EstadosEnum::COMPLETADO->value) {
                // Envio de correo a SUPERVISOR cuando SUBALTERNO marque como COMPLETADO
                $empSupervisor = User::find($accionReporte->id_usuario_supervisor)->email;
                Mail::to($empSupervisor)->send(new ReporteMailable('emails.aviso-supervisor', $tableData, 'Revisión disponible'));
            }
            Session::flash('message', [
                'type' => 'success',
                'content' => 'Seguimiento de reporte actualizado con éxito'
            ]);
        } catch (\Exception $e) {
            Session::flash('message', [
                'type' => 'error',
                'content' => 'Ocurrió un error inesperado'
            ]);
            return redirect()->action([ReporteController::class, 'detalle'], ['id' => $reporte->id]);

        }
        return redirect()->action([ReporteController::class, 'detalle'], ['id' => $reporte->id]);
    }

    public function filtrosGenerales(Request $request, Builder $query): void
    {
        $validated = $request->validate([
            'filter-radio' => 'nullable|string|in:hoy,7_dias,30_dias,mes,anio',
            'titulo' => 'nullable|string|max:50|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ ]+$/',
            'estado' => 'nullable|string|in:no_procede,no_asignado,1,2,3,4,5,6,7,8,9,10',
            'tipoReporte' => 'nullable|string|in:incidencia,actividad',
        ], [
            'filter-radio.in' => 'El filtro seleccionado no es válido',
            'titulo.max' => 'El título no debe exceder los 50 caracteres',
            'titulo.regex' => 'El título solo puede contener letras, números y espacios',
            'estado.in' => 'El estado seleccionado no es válido',
            'tipoReporte.in' => 'El tipo de reporte seleccionado no es válido',
        ]);
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

        if ($request->has('estado')) {
            $estado = $request->input('estado');
            if ($estado === 'no_procede') {
                $query->where('no_procede', true);
            } else if ($estado === 'no_asignado') {
                $query->whereDoesntHave('accionesReporte')->where('no_procede', false);
            } else {
                // Filtrar por el estado actual del reporte
                $query->whereHas('accionesReporte.historialAccionesReporte', function ($query) use ($estado) {
                    $query->where('id', function ($query) {
                        $query->select('id')
                            ->from('historial_acciones_reportes')
                            ->whereColumn('id_acciones_reporte', 'acciones_reportes.id')
                            ->latest()
                            ->limit(1);
                    })->where('id_estado', $estado);
                });
            }
        }

        if ($request->has('tipoReporte')) {
            // 'incidencia' o 'actividad'
            $tipo = $request->input('tipoReporte');
            if ($tipo === 'incidencia') {
                $query->whereNull('id_actividad');
            } else if ($tipo === 'actividad') {
                $query->whereNotNull('id_actividad');
            }
        }
    }

    public function infoDetalleReporte(Request $request, $id_reporte)
    {
        $reporte = Reporte::find($id_reporte);

        if (isset($reporte)) {
            // Necesario para asignacion
            $entidades = Entidades::where('activo', true)->get();
            $empPuesto = new EmpleadoPuestoController();
            $empleadosPorEntidad = $empPuesto->listadoEmpleadosPorUnidad($request->query('entidad'));
            $empleadosPorEntidad = collect($empleadosPorEntidad)->map(function ($empleado) {
                return json_decode(json_encode([
                    'id' => $empleado['id_empleado_puesto'],
                    'name' => $empleado['nombre_empleado'] . ' ' . $empleado['apellido_empleado'],
                    'correo' => $empleado['email'],
                    'puesto' => $empleado['nombre_puesto'],
                ]));
            })->toArray();
            $supervisores = collect($empPuesto->listadoSupervisores())->map(function ($supervisor) {
                return json_decode(json_encode($supervisor));
            })->toArray();
            // Necesarios para actualizacion y seguimiento de reporte
            $estController = new EstadoController();
            $estadosHabilitados = $estController->estadosReporte($reporte);

            // Catalogos para el detalle
            $fondos = DB::table('fondos')->where('activo', true)->get();
            $recursos = Recurso::where('activo', true)->get();
            $unidades_medida = DB::table('unidades_medida')->where('activo', true)->get();
            $tiposBienes = DB::table('tipos_bienes')->where('activo', true)->get();
            $categoriasReporte = DB::table('categoria_reportes')->where('activo', true)->get();

            return [
                'reporte' => $reporte,
                'accionesReporte' => $reporte->accionesReporte,
                'entidades' => $entidades,
                'empleadosPorEntidad' => $empleadosPorEntidad,
                'supervisores' => $supervisores,
                'estadosPermitidos' => $estadosHabilitados,
                'fondos' => $fondos,
                'recursos' => $recursos,
                'unidadesMedida' => $unidades_medida,
                'tiposBienes' => $tiposBienes,
                'reporteBienes' => $reporte->reporteBienes,
                'categoriasReporte' => $categoriasReporte
            ];
        } else {
            return [
                'reporte' => null,
                'entidades' => [],
                'empleadosPorEntidad' => [],
                'supervisores' => [],
                'estadosPermitidos' => [],
                'fondos' => [],
                'recursos' => [],
                'unidadesMedida' => [],
                'tiposBienes' => [],
                'reporteBienes' => [],
                'categoriasReporte' => []
            ];
        }
    }
}
