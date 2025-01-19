<x-app-layout>
    @php
        $colors = [
            'ASIGNADO' => 'bg-blue-500',
            'EN PROCESO' => 'bg-purple-500',
            'EN PAUSA' => 'bg-amber-500',
            'COMPLETADO' => 'bg-lime-500',
            'INCOMPLETO' => 'bg-orange-500',
            'FINALIZADO' => 'bg-green-500',
            'NO PROCEDE' => 'bg-red-500',
        ];
    @endphp

    <div class="mx-auto mt-20 px-4">
        <div class="mb-8 text-center">
            <h2 class="mb-4 text-4xl font-bold text-escarlata-ues">Bienvenido al Sistema de Reportes de Incidencias</h2>
            <p class="text-xl text-gray-600">Gestiona tus incidencias de manera eficiente y efectiva</p>
        </div>
        <div class="mb-12 grid gap-8 md:m-12 md:grid-cols-2 lg:m-20 lg:gap-12">
            <div
                class="transform rounded-lg border border-orange-900/30 bg-white/80 px-6 py-4 backdrop-blur-sm transition-all duration-300 hover:scale-105 hover:shadow-xl dark:border-orange-800 dark:bg-orange-950/80"
            >
                <div class="mb-6">
                    <div class="mb-1 text-lg font-bold text-escarlata-ues dark:text-orange-100 md:text-xl">
                        Reportar Nueva Incidencia
                    </div>
                    <div class="text-[14px] text-gray-800">Informa sobre un nuevo problema o solicitud</div>
                </div>
                <div>
                    <a
                        href="{{ route('crear-reporte') }}"
                        class="flex w-full items-center justify-center gap-3 rounded-md bg-escarlata-ues p-1.5 text-sm text-white hover:bg-orange-900/90"
                    >
                        <x-heroicon-o-plus-circle class="mr-2 h-4 w-4" />
                        Crear Incidencia
                    </a>
                </div>
            </div>
            <div
                class="transform rounded-lg border border-orange-900/30 bg-white/80 px-6 py-4 backdrop-blur-sm transition-all duration-300 hover:scale-105 hover:shadow-xl dark:border-orange-800 dark:bg-orange-950/80"
            >
                <div class="mb-6">
                    <div class="mb-1 text-lg font-bold text-escarlata-ues dark:text-orange-100 md:text-xl">
                        Ver Incidencias Reportadas
                    </div>
                    <div class="text-[14px] text-gray-800">Revisa y actualiza las incidencias en curso</div>
                </div>
                <div>
                    <a
                        href="{{ route('reportes-generales') }}"
                        class="flex w-full items-center justify-center gap-3 rounded-md bg-orange-100 p-1.5 text-sm text-escarlata-ues hover:bg-orange-300"
                    >
                        <x-heroicon-o-clock class="mr-2 h-4 w-4" />
                        Incidencias Activas
                    </a>
                </div>
            </div>
        </div>

        <div class="mb-8 rounded-lg bg-white p-6 shadow-md">
            <h2 class="mb-4 text-2xl font-bold text-escarlata-ues">Actividad Reciente</h2>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                    <h2 class="text-lg font-bold text-gray-800">Reportes Nuevos</h2>
                    <div class="text-2xl font-bold text-escarlata-ues">
                        {{ $dataReportesNuevos['reportesNuevos7Dias'] }}
                    </div>
                    <p class="text-xs text-gray-600">
                        {{ $dataReportesNuevos['porcentajeReportesNuevos'] }}% desde la última semana
                    </p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                    <h2 class="text-lg font-bold text-gray-800">En Proceso</h2>
                    <div class="text-2xl font-bold text-escarlata-ues">
                        {{ $dataReportesEnProceso['reportesEnProceso7Dias'] }}
                    </div>
                    <p class="text-xs text-gray-600">
                        {{ $dataReportesEnProceso['porcentajeReportesEnProceso'] }}% desde la última semana
                    </p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                    <h2 class="text-lg font-bold text-gray-800">Incidencias Resueltas</h2>
                    <div class="text-2xl font-bold text-escarlata-ues">
                        {{ $dataReportesFinalizados['reportesFinalizados7Dias'] }}
                    </div>
                    <p class="text-xs text-gray-600">
                        {{ $dataReportesFinalizados['porcentajeReportesFinalizados'] }}% desde la última semana
                    </p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                    <h2 class="text-lg font-bold text-gray-800">Incidencias Descartadas</h2>
                    <div class="text-2xl font-bold text-escarlata-ues">
                        {{ $dataReportesNoProcede['reportesNoProcede7Dias'] }}
                    </div>
                    <p class="text-xs text-gray-600">
                        {{ $dataReportesNoProcede['porcentajeReportesNoProcede'] }}% desde la última semana
                    </p>
                </div>
            </div>
            <div class="mt-6">
                <h3 class="mb-2 text-lg font-bold text-escarlata-ues">Últimas Actualizaciones</h3>
                <ul class="space-y-2">
                    @foreach ($actividadReciente as $actualizacion)
                        <li class="flex items-center space-x-2 rounded-xl bg-gray-50 p-2 hover:bg-gray-100">
                            @switch($actualizacion['acciones'])
                                @case('CREACION')
                                    <span class="h-3 w-3 rounded-full bg-teal-500"></span>

                                    @break
                                @default
                                    <span class="{{ $colors[$actualizacion['estado']] }} h-3 w-3 rounded-full"></span>
                            @endswitch
                            <span class="text-sm">
                                @switch($actualizacion['acciones'])
                                    @case('CREACION')
                                        Se ha creado el reporte de incidencia #{{ $actualizacion['reporte'] }}

                                        @break
                                    @default
                                        @if ($actualizacion['estado'] === 'FINALIZADO')
                                            Se ha marcado como {{ $actualizacion['estado'] }} la incidencia
                                            #{{ $actualizacion['reporte'] }}
                                        @else
                                            @if ($actualizacion['estado'] === 'ASIGNADO')
                                                Se ha asignado la incidencia #{{ $actualizacion['reporte'] }} para
                                                proceder a su resolución
                                            @else
                                                Se ha actualizado la incidencia #{{ $actualizacion['reporte'] }} a
                                                estado {{ $actualizacion['estado'] }}
                                            @endif
                                        @endif
                                @endswitch
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="mb-8 w-full overflow-hidden rounded-lg bg-white shadow-md">
            <div class="p-8">
                <h2 class="mb-4 text-2xl font-bold text-escarlata-ues">Estados de Incidencias</h2>
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-lg bg-white p-4 shadow">
                        <div class="flex items-center gap-3">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-yellow-600"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <h3 class="text-sm font-semibold">NO ASIGNADO</h3>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            El reporte no ha sido asignado a ningún empleado para su resolución.
                        </p>
                    </div>
                    <div class="rounded-lg bg-white p-4 shadow">
                        <div class="flex items-center gap-3">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-blue-600"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <polyline points="17 11 19 13 23 9"></polyline>
                            </svg>
                            <h3 class="text-sm font-semibold">ASIGNADO</h3>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            El reporte ha sido asignado a un empleado y está a punto de iniciar su resolución.
                        </p>
                    </div>
                    <div class="rounded-lg bg-white p-4 shadow">
                        <div class="flex items-center gap-3">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-green-600"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <circle cx="12" cy="12" r="10"></circle>
                                <polygon points="10 8 16 12 10 16 10 8"></polygon>
                            </svg>
                            <h3 class="text-sm font-semibold">EN PROCESO</h3>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            La solución de la incidencia se está llevando a cabo en este momento.
                        </p>
                    </div>
                    <div class="rounded-lg bg-white p-4 shadow">
                        <div class="flex items-center gap-3">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-orange-600"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <rect x="6" y="4" width="4" height="16"></rect>
                                <rect x="14" y="4" width="4" height="16"></rect>
                            </svg>
                            <h3 class="text-sm font-semibold">EN PAUSA</h3>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            La resolución de la incidencia está pausada debido a falta de recursos, una actividad
                            pendiente o cualquier razón que requiera una espera.
                        </p>
                    </div>
                    <div class="rounded-lg bg-white p-4 shadow">
                        <div class="flex items-center gap-3">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-purple-600"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <h3 class="text-sm font-semibold">COMPLETADO</h3>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            La solución está parcialmente completada, ya que el trabajo ha sido realizado, pero el
                            supervisor debe confirmarlo.
                        </p>
                    </div>
                    <div class="rounded-lg bg-white p-4 shadow">
                        <div class="flex items-center gap-3">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-green-700"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <h3 class="text-sm font-semibold">FINALIZADO</h3>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            El reporte ha sido confirmado por el supervisor y la solución se considera completada.
                        </p>
                    </div>
                    <div class="rounded-lg bg-white p-4 shadow">
                        <div class="flex items-center gap-3">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-red-600"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                            <h3 class="text-sm font-semibold">INCOMPLETO</h3>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            El supervisor ha cerrado el reporte indicando que la solución no está completada.
                        </p>
                    </div>
                    <div class="rounded-lg bg-white p-4 shadow">
                        <div class="flex items-center gap-3">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 text-gray-600"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                            </svg>
                            <h3 class="text-sm font-semibold">NO PROCEDE</h3>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            El reporte no puede proceder porque la incidencia no se puede resolver, no es válida o es
                            falsa.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
