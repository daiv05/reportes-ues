@php
    // type: 1 = normal, 2 dropdown
    $sidebarItems = [
        [
            'type' => 1,
            'to' => 'dashboard',
            'active' => request()->is('inicio'),
            'icon' => 'heroicon-s-chart-pie',
            'label' => 'Inicio',
        ],
        [
            'type' => 2,
            'id' => 'seguridad-dropdown',
            'active' => request()->is('seguridad/*'),
            'icon' => 'heroicon-s-lock-closed',
            'label' => 'Seguridad',
            'items' => [
                [
                    'to' => 'roles.index',
                    'active' => request()->is('seguridad/roles'),
                    'label' => 'Roles',
                ],
                [
                    'to' => 'usuarios.index',
                    'active' => request()->is('seguridad/usuarios'),
                    'label' => 'Usuarios',
                ],
            ],
        ],
        [
            'type' => 2,
            'id' => 'reportes-dropdown',
            'active' => request()->is('reportes/*'),
            'icon' => 'heroicon-s-document-chart-bar',
            'label' => 'Reportes',
            'items' => [
                [
                    'to' => 'reportes-generales',
                    'active' => request()->is('reportes/listado-general'),
                    'label' => 'Listado',
                ],
                [
                    'to' => 'reportes.misReportes',
                    'active' => request()->is('reportes/mis-reportes'),
                    'label' => 'Mis reportes',
                ],
                [
                    'to' => 'reportes.misAsignaciones',
                    'active' => request()->is('reportes/mis-asignaciones'),
                    'label' => 'Mis asignaciones',
                ]
            ],
        ],
        [
            'type' => 2,
            'id' => 'actividades-dropdown',
            'active' => request()->is('actividades/*'),
            'icon' => 'heroicon-s-calendar-days',
            'label' => 'Actividades',
            'items' => [
                [
                    'to' => 'listado-clases',
                    'active' => request()->is('actividades/clases'),
                    'label' => 'Clases',
                ],
                [
                    'to' => 'listado-eventos-evaluaciones',
                    'active' => request()->is('actividades/eventos-y-evaluaciones'),
                    'label' => 'Eventos',
                ],
                [
                    'to' => 'importar-actividades',
                    'active' => request()->is('actividades/importacion-actividades'),
                    'label' => 'Importación de actividades',
                ],
            ],
        ],
        [
            'type' => 2,
            'id' => 'rhu-dropdown',
            'active' => request()->is('rhu/*'),
            'icon' => 'heroicon-s-user-group',
            'label' => 'Recursos humanos',
            'items' => [
                [
                    'to' => 'entidades.index',
                    'active' => request()->is('rhu/entidades'),
                    'label' => 'Entidades',
                ],
                [
                    'to' => 'puestos.index',
                    'active' => request()->is('rhu/puestos'),
                    'label' => 'Puestos',
                ],
                [
                    'to' => 'empleadosPuestos.index',
                    'active' => request()->is('rhu/empleado-puesto'),
                    'label' => 'Empleados - Puestos',
                ]
            ],
        ],
        [
            'type' => 2,
            'id' => 'mantenimientos-dropdown',
            'active' => request()->is('mantenimientos/*'),
            'icon' => 'heroicon-s-table-cells',
            'label' => 'Mantenimientos',
            'items' => [
                [
                    'to' => 'aulas.index',
                    'active' => request()->is('mantenimientos/aulas'),
                    'label' => 'Aulas',
                ],
                [
                    'to' => 'escuela.index',
                    'active' => request()->is('mantenimientos/escuelas'),
                    'label' => 'Escuelas',
                ],
                [
                    'to' => 'asignaturas.index',
                    'active' => request()->is('mantenimientos/asignaturas'),
                    'label' => 'Asignaturas',
                ],
                [
                    'to' => 'ciclos.index',
                    'active' => request()->is('mantenimientos/ciclos'),
                    'label' => 'Ciclos',
                ],
            ],
        ],
        [
            'type' => 2,
            'id' => 'maquetacion-dropdown',
            'active' => request()->is('maquetacion/*'),
            'icon' => 'heroicon-s-exclamation-triangle',
            'label' => 'Maquetación',
            'items' => [
                [
                    'to' => 'dashboard',
                    'active' => request()->is('maquetacion/general'),
                    'label' => 'Componentes globales',
                ],
                // [
                //     'to' => 'detalle-reporte',
                //     'active' => request()->is('reportes/detalle'),
                //     'label' => 'Detalle de reporte',
                // ],
            ],
        ],
        [
            'type' => 2,
            'id' => 'auditorias-dropdown',
            'active' => request()->is('auditorias/*'),
           'icon' => 'heroicon-s-book-open',
            'label' => 'Auditorias',
            'items' => [
                [
                    'to' => 'general.index',
                    'active' => request()->is('auditorias/general'),
                    'label' => 'General',
                ],
                // [
                //     'to' => 'detalle-reporte',
                //     'active' => request()->is('reportes/detalle'),
                //     'label' => 'Detalle de reporte',
                // ],
            ],
        ],
    ];
@endphp

<aside id="logo-sidebar"
    class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full border-r border-gray-200 bg-white pt-24 transition-transform dark:border-gray-700 dark:bg-gray-800 md:translate-x-0">
    <div class="h-full overflow-y-auto bg-white px-3 pb-4 dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @foreach ($sidebarItems as $sit)
                @if ($sit['type'] === 1)
                    <x-aside.base :to="$sit['to']" :active="$sit['active']" :icon="$sit['icon']" :label="$sit['label']" />
                @elseif ($sit['type'] === 2)
                    <x-aside.dropdown id="{{ $sit['id'] }}" :active="$sit['active']" :icon="$sit['icon']" :label="$sit['label']" />
                    <ul id="{{ $sit['id'] }}" class="hidden space-y-2 py-2">
                        @foreach ($sit['items'] as $item)
                            <x-aside.dropdown-item :to="$item['to']" :active="$item['active']" :label="$item['label']" />
                        @endforeach
                    </ul>
                @else
                    {{ error_log('Tipo de item no reconocido') }}
                @endif
            @endforeach
        </ul>
    </div>
</aside>
