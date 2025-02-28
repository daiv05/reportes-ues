<?php

namespace App\Http\Controllers\Estadisticas;

use App\Http\Controllers\Controller;
use App\Models\CategoriaReporte;
use App\Models\Mantenimientos\Recurso;
use App\Models\Reportes\EmpleadoAccion;
use App\Models\Reportes\Estado;
use App\Models\Reportes\RecursoReporte;
use App\Models\Reportes\Reporte;
use App\Models\rhu\EmpleadoPuesto;
use App\Models\rhu\Entidades;
use App\Models\Seguridad\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;


class EstadisticasController extends Controller
{
    public function index(Request $request)
    {

        /*************************************************
         * ESTADISTICAS DE REPORTES POR ESTADO
         ************************************************/
        $estados = Estado::orderBy('id')->where('activo', true)->pluck('nombre');
        $estados->push('NO ASIGNADO');
        $estados->push('NO PROCEDE');

        $reportesNoProcede = Reporte::where('no_procede', true)->where('activo', true);
        $reportes = Reporte::where('no_procede', false)->where('activo', true);

        if ($request->has('filter-radio')) {
            $filtro = $request->input('filter-radio');

            switch ($filtro) {
                case 'hoy':
                    $reportes->whereDate('fecha_reporte', today());
                    $reportesNoProcede->whereDate('fecha_reporte', today());
                    break;
                case '7_dias':
                    $reportes->where('fecha_reporte', '>=', now()->subDays(7));
                    $reportesNoProcede->where('fecha_reporte', '>=', now()->subDays(7));
                    break;
                case '30_dias':
                    $reportes->where('fecha_reporte', '>=', now()->subDays(30));
                    $reportesNoProcede->where('fecha_reporte', '>=', now()->subDays(30));
                    break;
                case 'mes':
                    $reportes->where('fecha_reporte', '>=', now()->subMonth());
                    $reportesNoProcede->where('fecha_reporte', '>=', now()->subMonth());
                    break;
                case 'anio':
                    $reportes->where('fecha_reporte', '>=', now()->subYear());
                    $reportesNoProcede->where('fecha_reporte', '>=', now()->subYear());
                    break;
            }
        }

        $reportes = $reportes->get();
        $reportesNoProcede = $reportesNoProcede->count();

        $conteoReportesPorEstado = [];

        foreach ($estados as $estado) {
            $conteoReportesPorEstado[$estado] = 0;
        }
        $conteoReportesPorEstado['NO PROCEDE'] = $reportesNoProcede;

        foreach ($reportes as $reporte) {
            if ($reporte->estado_ultimo_historial == null) {
                $conteoReportesPorEstado['NO ASIGNADO'] = $conteoReportesPorEstado['NO ASIGNADO'] + 1;
            } else {
                $estado = Estado::find($reporte->estado_ultimo_historial->id)->nombre;
                $conteoReportesPorEstado[$estado] = $conteoReportesPorEstado[$estado] + 1;
            }
        }

        $chartReportesEstados = [
            'type' => 'bar',
            'labels' => $estados,
            'datasets' => [
                'data' => $conteoReportesPorEstado,
                'backgroundColor' => [
                    '#BFDBFE',       // bg-blue-100
                    '#E9D5FF',     // bg-purple-100
                    '#FEF3C7',       // bg-amber-100
                    '#365314',     // bg-lime-800
                    '#D1FAE5',     // bg-green-100
                    '#FFEDD5',     // bg-orange-100
                    '#EA580C',    // bg-orange-600
                    '#1F2937',     // bg-gray-800
                ],
            ]
        ];

        /*************************************************
         * ESTADISTICAS DE RECURSOS MAS UTILIZADOS
         ************************************************/

        $recursosUtilizados = [];
        $recursosMenosUtilizados = [];

        $recursosRaw = Recurso::where('recursos.activo', true)->join('recursos_reportes', 'recursos.id', '=', 'recursos_reportes.id_recurso')
            ->leftJoin('fondos', 'recursos_reportes.id_fondo', '=', 'fondos.id')
            ->leftJoin('unidades_medida', 'recursos_reportes.id_unidad_medida', '=', 'unidades_medida.id')
            ->select(
                'recursos_reportes.id_recurso',
                'recursos.nombre as recurso_nombre',
                'recursos_reportes.cantidad',
                'fondos.nombre as fondo_nombre',
                'unidades_medida.nombre as unidad_medida_nombre'
            )
            ->orderBy('recursos_reportes.id_recurso', 'asc');

        if ($request->has('filter-radio')) {
            $filtro = $request->input('filter-radio');
            switch ($filtro) {
                case 'hoy':
                    $recursosRaw->whereDate('recursos_reportes.created_at', today());
                    break;
                case '7_dias':
                    $recursosRaw->where('recursos_reportes.created_at', '>=', now()->subDays(7));
                    break;
                case '30_dias':
                    $recursosRaw->where('recursos_reportes.created_at', '>=', now()->subDays(30));
                    break;
                case 'mes':
                    $recursosRaw->where('recursos_reportes.created_at', '>=', now()->subMonth());
                    break;
                case 'anio':
                    $recursosRaw->where('recursos_reportes.created_at', '>=', now()->subYear());
                    break;
            }
        };

        $recursosRaw = $recursosRaw->get();

        foreach ($recursosRaw as $row) {
            $idRecurso = $row->id_recurso;

            // Inicializar el recurso si no existe en el arreglo final
            if (!isset($recursosUtilizados[$idRecurso])) {
                $recursosUtilizados[$idRecurso] = [
                    'id_recurso' => $row->id_recurso,
                    'recurso_nombre' => $row->recurso_nombre,
                    'cantidad' => 0, // Inicializamos la cantidad
                    'fondos' => [],
                    'unidades_medida' => [],
                ];
            }

            // Sumar la cantidad
            $recursosUtilizados[$idRecurso]['cantidad'] += $row->cantidad;

            // Agregar fondo si no está duplicado
            if (!in_array($row->fondo_nombre, $recursosUtilizados[$idRecurso]['fondos']) && $row->fondo_nombre !== null) {
                $recursosUtilizados[$idRecurso]['fondos'][] = $row->fondo_nombre;
            }

            // Agregar unidad de medida si no está duplicada
            if (!in_array($row->unidad_medida_nombre, $recursosUtilizados[$idRecurso]['unidades_medida']) && $row->unidad_medida_nombre !== null) {
                $recursosUtilizados[$idRecurso]['unidades_medida'][] = $row->unidad_medida_nombre;
            }
        }

        $recursosMenosUtilizados = $recursosUtilizados;

        // Convertir el resultado a un array numérico
        usort($recursosUtilizados, function ($a, $b) {
            return $b['cantidad'] <=> $a['cantidad']; // Orden descendente
        });

        // Ordenar ascendentemente por cantidad
        usort($recursosMenosUtilizados, function ($a, $b) {
            return $a['cantidad'] <=> $b['cantidad']; // Orden ascendente
        });

        $recursosUtilizados = collect($recursosUtilizados)->take(8);
        $recursosMenosUtilizados = collect($recursosMenosUtilizados)->take(8);


        $chartRecursosUtilizados = [
            'type' => 'pie',
            'labels' => $recursosUtilizados->pluck('recurso_nombre'),
            'datasets' => [
                'data' => $recursosUtilizados->pluck('cantidad'),
                'backgroundColor' => [
                    '#86E3CE',
                    '#D0E6A5',
                    '#FFDD94',
                    '#FA897B',
                    '#CCABD8',
                    '#596EE2|',
                    '#7FACD6',
                    '#FEAEBB',
                ],
            ]
        ];

        $chartRecursosMenosUtilizados = [
            'type' => 'pie',
            'labels' => $recursosMenosUtilizados->pluck('recurso_nombre'),
            'datasets' => [
                'data' => $recursosMenosUtilizados->pluck('cantidad'),
                'backgroundColor' => [
                    '#96151a',
                    '#e8c4bc',
                    '#d3484e',
                    '#ac7173',
                    '#c4091d',
                    '#450f10',
                    '#f7ded4',
                    '#6a1315',
                ],
            ]
        ];

        /*************************************************
         * ESTADISTICAS DE RECURSOS POR FONDOS
         ************************************************/

        $recursosPorFondos = RecursoReporte::join('fondos', 'recursos_reportes.id_fondo', '=', 'fondos.id')
            ->select('fondos.nombre as fondo_nombre', 'recursos_reportes.id_recurso')
            ->orderBy('fondo_nombre');

        if ($request->has('filter-radio')) {
            $filtro = $request->input('filter-radio');
            switch ($filtro) {
                case 'hoy':
                    $recursosPorFondos->whereDate('recursos_reportes.created_at', today());
                    break;
                case '7_dias':
                    $recursosPorFondos->where('recursos_reportes.created_at', '>=', now()->subDays(7));
                    break;
                case '30_dias':
                    $recursosPorFondos->where('recursos_reportes.created_at', '>=', now()->subDays(30));
                    break;
                case 'mes':
                    $recursosPorFondos->where('recursos_reportes.created_at', '>=', now()->subMonth());
                    break;
                case 'anio':
                    $recursosPorFondos->where('recursos_reportes.created_at', '>=', now()->subYear());
                    break;
            }
        };

        $recursosPorFondos = $recursosPorFondos->get()
            ->groupBy('fondo_nombre') // Agrupar por nombre del fondo
            ->map(function ($recursos, $fondoNombre) {
                // Contar la cantidad de recursos por fondo
                return [
                    'nombre' => $fondoNombre,
                    'cantidad' => $recursos->count()
                ];
            });

        // Calcular el total de recursos para el cálculo de porcentaje
        $totalRecursos = $recursosPorFondos->sum('cantidad');

        // Agregar el porcentaje a cada fondo
        $recursosPorFondos = $recursosPorFondos->map(function ($fondoData) use ($totalRecursos) {
            $fondoData['porcentaje'] = round(($fondoData['cantidad'] / $totalRecursos) * 100, 2);
            return $fondoData;
        });

        $chartRecursosPorFondos = [
            'type' => 'pie',
            'labels' => $recursosPorFondos->pluck('nombre'),
            'datasets' => [
                'data' => $recursosPorFondos->pluck('porcentaje'),
                'backgroundColor' => [
                    '#5ca4a9',
                    '#ed6a5a',
                ],
            ]
        ];


        /*************************************************
         * EMPLEADOS CON MAS ASIGNACIONES
         ************************************************/

        $empleadosAsignaciones = EmpleadoAccion::where('empleados_puestos.activo', true)
            ->join('empleados_puestos', 'empleados_acciones.id_empleado_puesto', '=', 'empleados_puestos.id')
            ->join('users', 'empleados_puestos.id_usuario', '=', 'users.id')
            ->join('personas', 'users.id_persona', '=', 'personas.id')
            ->selectRaw("CONCAT(personas.nombre, ' ', personas.apellido) as empleado_nombre_completo, COUNT(empleados_acciones.id) as numero_asignaciones")
            ->groupByRaw("CONCAT(personas.nombre, ' ', personas.apellido)");


        $empleadosMasAsignaciones = $empleadosAsignaciones->orderBy('numero_asignaciones', 'DESC');
        $cloneAsignaciones = clone $empleadosAsignaciones;

        $empleadosMenosAsignaciones = EmpleadoPuesto::whereDoesntHave('empleadosAcciones')
            ->join('users', 'empleados_puestos.id_usuario', '=', 'users.id')
            ->join('personas', 'users.id_persona', '=', 'personas.id')
            ->selectRaw("CONCAT(personas.nombre, ' ', personas.apellido) as empleado_nombre_completo, 0 as numero_asignaciones");

        $empleadosMenosAsignaciones = $cloneAsignaciones->union($empleadosMenosAsignaciones)->orderBy('numero_asignaciones', 'ASC');




        if ($request->has('filter-radio')) {
            $filtro = $request->input('filter-radio');
            switch ($filtro) {
                case 'hoy':
                    $empleadosMasAsignaciones->whereDate('empleados_acciones.created_at', today());
                    $empleadosMenosAsignaciones->whereDate('empleados_acciones.created_at', today());
                    break;
                case '7_dias':
                    $empleadosMasAsignaciones->where('empleados_acciones.created_at', '>=', now()->subDays(7));
                    $empleadosMenosAsignaciones->where('empleados_acciones.created_at', '>=', now()->subDays(7));
                    break;
                case '30_dias':
                    $empleadosMasAsignaciones->where('empleados_acciones.created_at', '>=', now()->subDays(30));
                    $empleadosMenosAsignaciones->where('empleados_acciones.created_at', '>=', now()->subDays(30));
                    break;
                case 'mes':
                    $empleadosMasAsignaciones->where('empleados_acciones.created_at', '>=', now()->subMonth());
                    $empleadosMenosAsignaciones->where('empleados_acciones.created_at', '>=', now()->subMonth());
                    break;
                case 'anio':
                    $empleadosMasAsignaciones->where('empleados_acciones.created_at', '>=', now()->subYear());
                    $empleadosMenosAsignaciones->where('empleados_acciones.created_at', '>=', now()->subYear());
                    break;
            }
        };

        $empleadosMasAsignaciones = $empleadosMasAsignaciones->get()->take(5);
        $empleadosMenosAsignaciones = $empleadosMenosAsignaciones->get()->take(5);


        $chartEmpleadosMasAsignaciones = [
            'type' => 'bar',
            'labels' => $empleadosMasAsignaciones->pluck('empleado_nombre_completo'),
            'datasets' => [
                'data' => $empleadosMasAsignaciones->pluck('numero_asignaciones'),
                'backgroundColor' => [
                    '#729ea1',
                    '#b5bd89',
                    '#dfbe99',
                    '#ec9192',
                    '#db5375',
                ],
            ]
        ];


        $chartEmpleadosMenosAsignaciones = [
            'type' => 'bar',
            'labels' => $empleadosMenosAsignaciones->pluck('empleado_nombre_completo'),
            'datasets' => [
                'data' => $empleadosMenosAsignaciones->pluck('numero_asignaciones'),
                'backgroundColor' => [
                    '#ffa37a',
                    '#064f7e',
                    '#1c282b',
                    '#c37dd9',
                    '#333333',
                ],
            ]
        ];

        return view(
            'estadisticas.index',
            [
                // Estadisticas de reportes por estado
                'chartReportesEstados' => $chartReportesEstados,
                'estados' => $estados,
                'conteoReportesPorEstado' => $conteoReportesPorEstado,

                // Estadisticas de recursos mas utilizados
                'chartRecursosUtilizados' => $chartRecursosUtilizados,
                'recursosUtilizados' => $recursosUtilizados,

                // Estadisticas de recursos menos utilizados
                'chartRecursosMenosUtilizados' => $chartRecursosMenosUtilizados,
                'recursosMenosUtilizados' => $recursosMenosUtilizados,

                // Estadisticas de recursos utilizados por fondos
                'chartRecursosPorFondos' => $chartRecursosPorFondos,
                'recursosPorFondos' => $recursosPorFondos,

                // Empleados con mas asignaciones
                'chartEmpleadosMasAsignaciones' => $chartEmpleadosMasAsignaciones,
                'empleadosMasAsignaciones' => $empleadosMasAsignaciones,

                // Empleados con menos asignaciones
                'chartEmpleadosMenosAsignaciones' => $chartEmpleadosMenosAsignaciones,
                'empleadosMenosAsignaciones' => $empleadosMenosAsignaciones,
            ]
        );
    }

    public function calcularEficienciaEmpleados(Request $request)
    {

        $orderEnum = ['asc', 'desc'];
        $orderByEnum = ['horasTrabajadas', 'horasEnPausa', 'totalReportesFinalizados', 'indiceEficiencia'];

        $validated = $request->validate([
            'fecha_inicio' => 'nullable|date_format:d/m/Y',
            'fecha_final' => 'nullable|date_format:d/m/Y',
            'id_entidad' => 'nullable|integer|exists:entidades,id',
            'nombreEmpleado' => 'nullable|string|max:50|regex:/^[a-zA-Z\sáéíóúñÁÉÍÓÚÑ]+$/',
            'order' => 'nullable|string|in:' . implode(',', $orderEnum),
            'orderBy' => 'nullable|string|in:' . implode(',', $orderByEnum),
        ], [
            'id_entidad.integer' => 'El id de la entidad debe ser un número entero',
            'id_entidad.exists' => 'La entidad seleccionada no existe',
            'nombreEmpleado.string' => 'El nombre del empleado debe ser una cadena de texto',
            'nombreEmpleado.max' => 'El nombre del empleado no debe exceder los 50 caracteres',
            'nombreEmpleado.regex' => 'El nombre del empleado solo puede contener letras y espacios',
            'order.in' => 'El ordenamiento debe ser ASC o DESC',
            'orderBy.in' => 'El campo por el cual ordenar no es válido',
            'fecha_inicio.date_format' => 'La fecha de inicio no tiene un formato válido',
            'fecha_final.date_format' => 'La fecha final no tiene un formato válido',
        ]);

        $estadoId = Estado::where('nombre', 'FINALIZADO')->value('id');

        $userQuery = User::query();

        $userQuery->select('id', 'email', 'id_persona')->with([
            'empleadosPuestos.empleadosAcciones.reporte',
            'persona',
        ])->whereHas('empleadosPuestos', function ($query) {
            $query->where('empleados_puestos.activo', true);
        });

        if (isset($validated['nombreEmpleado'])) {
            $userQuery->whereHas('persona', function ($query) use ($validated) {
                $query->where('nombre', 'like', '%' . $validated['nombreEmpleado'] . '%')
                    ->orWhere('apellido', 'like', '%' . $validated['nombreEmpleado'] . '%');
            });
        }
        
        if (isset($validated['id_entidad'])) {
            $userQuery->whereHas('empleadosPuestos.puesto.entidad', function ($query) use ($validated) {
                $query->where('id', $validated['id_entidad']);
            });
        }

        $userQuery->whereHas('empleadosPuestos.empleadosAcciones.reporte.accionesReporte.historialAccionesReporte', function ($query) use ($estadoId, $request, $validated) {
            $query->where('id', function ($query) {
                $query->select('id')
                    ->from('historial_acciones_reportes')
                    ->whereColumn('id_acciones_reporte', 'acciones_reportes.id')
                    ->latest()
                    ->limit(1);
            })->where('id_estado', $estadoId);
            if (isset($validated['fecha_inicio'])) {
                $query->where('created_at', '>=', Carbon::createFromFormat('d/m/Y', $validated['fecha_inicio'] )->format('Y-m-d 00:00:00'));
            }
            if (isset($validated['fecha_final'])) {
                $query->where('created_at', '<=', Carbon::createFromFormat('d/m/Y', $validated['fecha_final'] )->format('Y-m-d 23:59:59'));
            }
        });

        $users = $userQuery->get();


        // Consolidamos los reportes en una sola lista por usuario
        $users = $users->map(function ($user) use ($estadoId) {
            $reportes = collect();
            foreach ($user->empleadosPuestos as $puesto) {
                foreach ($puesto->empleadosAcciones as $accion) {
                    $reporte = $accion->reporte;
                    if ($reporte && ! $reporte->no_procede) {
                        if ($reporte->estado_ultimo_historial && $reporte->estado_ultimo_historial->id == $estadoId) {
                            $reporte['id_categoria_reporte'] = $reporte->accionesReporte->id_categoria_reporte;
                            // Historial ordenado por fecha created_at
                            // $reporte['historialEstados'] = $reporte->accionesReporte->historialAccionesReporte->sortBy('created_at');
                            $reportes->push($reporte);
                        }
                    }
                }
            }

            return [
                'id' => $user->id,
                'nombre' => $user->persona->nombre . ' ' . $user->persona->apellido,
                'email' => $user->email,
                'reportes' => $reportes->unique('id')->values(),
            ];
        });

        // Calculo de eficiencia
        $listaEmpleados = $users->map(function ($user) {
            $categorias = CategoriaReporte::all();
            $totalReportesAtendidos = $user['reportes']->count();
            $user['totalReportesFinalizados'] = $totalReportesAtendidos;
            $reportesPorCategoria = $user['reportes']->groupBy('id_categoria_reporte');
            $sumaEficiencia = 0;
            $sumaMinutosEnPausa = 0;
            $sumaDuracionReal = 0;
            foreach ($reportesPorCategoria as $categoriaId => $reportes) {
                $categoria = $categorias->find($categoriaId);
                foreach ($reportes as $reporte) {
                    // Calcular tiempo de reporte en pausa
                    $historialEstados = $reporte->accionesReporte->historialAccionesReporte;
                    $tiempoEnPausa = 0;
                    $estadoAnterior = null;
                    foreach ($historialEstados as $historial) {
                        if ($estadoAnterior && $estadoAnterior->estado->nombre == 'EN PAUSA') {
                            $tiempoEnPausa += $estadoAnterior->created_at->diffInMinutes($historial->created_at);
                        }
                        $estadoAnterior = $historial;
                    }
                    $minutosEnPausa = $tiempoEnPausa;
                    // Duracion real del reporte
                    $fechaInicio = Carbon::parse($reporte->accionesReporte->fecha_inicio);
                    $horaInicio = Carbon::parse($reporte->accionesReporte->hora_inicio);
                    $fechaFinalizacion = Carbon::parse($reporte->accionesReporte->fecha_finalizacion);
                    $horaFinalizacion = Carbon::parse($reporte->accionesReporte->hora_finalizacion);
                    $duracionReal = $fechaInicio->diffInMinutes($fechaFinalizacion) + $horaInicio->diffInMinutes($horaFinalizacion) ?? 1;
                    // Duracion maxima estimada segun categoria
                    $duracionEstimada = $categoria->tiempo_promedio ?? 1;
                    // Eficiencia acumulada
                    $sumaEficiencia += ($duracionEstimada / ($duracionReal - $minutosEnPausa));
                    $sumaDuracionReal += $duracionReal;
                    $sumaMinutosEnPausa += $minutosEnPausa;
                }
            }
            $user['indiceEficiencia'] =  round($totalReportesAtendidos > 0 ? $sumaEficiencia / $totalReportesAtendidos : 0, 2);
            $user['horasEnPausa'] = round($sumaMinutosEnPausa / 60, 2);
            $user['horasTrabajadas'] = round($sumaDuracionReal / 60, 2);
            return $user;
        });

        $listaEmpleados = $listaEmpleados->sortBy([
            [
                isset($validated['orderBy']) ? $validated['orderBy'] : 'indiceEficiencia',
                isset($validated['order']) ? $validated['order'] : 'desc'
            ]
        ])->values();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;

        $currentItems = $listaEmpleados->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $currentItems,
            $listaEmpleados->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath(), 'query' => $request->query()]
        );

        $chartEmpleadosEficiencia = [
            'type' => 'bar',
            'labels' => $currentItems->pluck('nombre'),
            'datasets' => [
                'data' => $currentItems->pluck('indiceEficiencia'),
                // 10 colores diferentes
                'backgroundColor' => [
                    '#86E3CE',
                    '#D0E6A5',
                    '#FFDD94',
                    '#FA897B',
                    '#CCABD8',
                    '#596EE2',
                    '#7FACD6',
                    '#FEAEBB',
                    '#FFD700',
                    '#FF6347',
                ],
            ]
        ];

        $entidades = Entidades::all();

        return view('estadisticas.empleados', [
            'listaEmpleados' => $paginator,
            'chartEmpleadosEficiencia' => $chartEmpleadosEficiencia,
            'entidades' => $entidades
        ]);
    }
}
