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
            'type' => 1,
            'to' => 'reportes-generales',
            'active' => request()->is('reportes/*'),
            'icon' => 'heroicon-s-document-chart-bar',
            'label' => 'Reportes',
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
                    'to' => 'departamentos.index',
                    'active' => request()->is('mantenimientos/departamentos'),
                    'label' => 'Departamentos',
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
                [
                    'to' => 'detalle-reporte',
                    'active' => request()->is('reportes/detalle'),
                    'label' => 'Detalle de reporte',
                ],
            ],
        ],
    ];
@endphp

<aside id="logo-sidebar"
    class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full border-r border-gray-200 bg-white pt-24 transition-transform dark:border-gray-700 dark:bg-gray-800 sm:translate-x-0"
    aria-label="Sidebar">
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
