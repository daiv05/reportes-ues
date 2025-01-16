@php
    // type: 1 = normal, 2 dropdown
    $sidebarItems = [
        [
            'type' => 1,
            'to' => 'dashboard',
            'active' => request()->is('inicio'),
            'icon' => 'heroicon-s-chart-pie',
            'label' => 'Inicio',
            'permissions' => false,
        ],
        [
            'type' => 2,
            'id' => 'seguridad-dropdown',
            'active' => request()->is('seguridad/*'),
            'icon' => 'heroicon-s-lock-closed',
            'label' => 'Seguridad',
            'permissions' => ['USUARIOS_VER','ROLES_VER'],
            'items' => [
                [
                    'to' => 'roles.index',
                    'active' => request()->is('seguridad/roles*'),
                    'label' => 'Roles',
                    'permissions' => ['ROLES_VER'],
                ],
                [
                    'to' => 'usuarios.index',
                    'active' => request()->is('seguridad/usuarios'),
                    'label' => 'Usuarios',
                    'permissions' => ['USUARIOS_VER'],
                ],
            ],
        ],
        [
            'type' => 2,
            'id' => 'reportes-dropdown',
            'active' => request()->is('reportes/*'),
            'icon' => 'heroicon-s-document-chart-bar',
            'label' => 'Reportes',
            'permissions' => ['REPORTES_VER_LISTADO_GENERAL'],
            'items' => [
                [
                    'to' => 'reportes-generales',
                    'active' => request()->is('reportes/listado-general'),
                    'label' => 'Listado',
                    'permissions' => ['REPORTES_VER_LISTADO_GENERAL'],
                ],
                [
                    'to' => 'reportes.misReportes',
                    'active' => request()->is('reportes/mis-reportes'),
                    'label' => 'Mis reportes',
                    'permissions' => ['REPORTES_CREAR'],
                ],
                [
                    'to' => 'reportes.misAsignaciones',
                    'active' => request()->is('reportes/mis-asignaciones'),
                    'label' => 'Mis asignaciones',
                    'permissions' => ['REPORTES_VER_ASIGNACIONES'],
                ],
            ],
        ],
        [
            'type' => 2,
            'id' => 'actividades-dropdown',
            'active' => request()->is('actividades/*'),
            'icon' => 'heroicon-s-calendar-days',
            'label' => 'Actividades',
            'permissions' => ['EVENTOS_VER', 'CLASES_VER'],
            'items' => [
                [
                    'to' => 'listado-clases',
                    'active' => request()->is('actividades/clases'),
                    'label' => 'Clases',
                    'permissions' => ['CLASES_VER'],
                ],
                [
                    'to' => 'listado-eventos-evaluaciones',
                    'active' => request()->is('actividades/eventos-y-evaluaciones'),
                    'label' => 'Eventos',
                    'permissions' => ['EVENTOS_VER'],
                ],
                [
                    'to' => 'importar-actividades',
                    'active' => request()->is('actividades/importar-actividades'),
                    'label' => 'Importación de actividades',
                    'permissions' => ['ACTIVIDADES_CARGA_EXCEL'],
                ],
            ],
        ],
        [
            'type' => 2,
            'id' => 'rhu-dropdown',
            'active' => request()->is('recursos-humanos/*'),
            'icon' => 'heroicon-s-user-group',
            'label' => 'Recursos humanos',
            'permissions' => ['ENTIDADES_VER', 'PUESTOS_VER', 'EMPLEADOS_VER'],
            'items' => [
                [
                    'to' => 'entidades.index',
                    'active' => request()->is('recursos-humanos/entidades'),
                    'label' => 'Entidades',
                    'permissions' => ['ENTIDADES_VER'],
                ],
                [
                    'to' => 'puestos.index',
                    'active' => request()->is('recursos-humanos/puestos'),
                    'label' => 'Puestos',
                    'permissions' => ['PUESTOS_VER'],
                ],
                [
                    'to' => 'empleadosPuestos.index',
                    'active' => request()->is('recursos-humanos/empleados'),
                    'label' => 'Empleados',
                    'permissions' => ['EMPLEADOS_VER'],
                ],
            ],
        ],
        [
            'type' => 2,
            'id' => 'mantenimientos-dropdown',
            'active' => request()->is('mantenimientos/*'),
            'icon' => 'heroicon-s-table-cells',
            'label' => 'Mantenimientos',
            'permissions' => ['AULAS_VER', 'ESCUELAS_VER', 'ASIGNATURAS_VER', 'CICLOS_VER', 'RECURSOS_VER', 'UNIDADES_MEDIDA_VER'],
            'items' => [
                [
                    'to' => 'aulas.index',
                    'active' => request()->is('mantenimientos/aulas'),
                    'label' => 'Aulas',
                    'permissions' => ['AULAS_VER'],
                ],
                [
                    'to' => 'escuela.index',
                    'active' => request()->is('mantenimientos/escuela'),
                    'label' => 'Escuelas',
                    'permissions' => ['ESCUELAS_VER'],
                ],
                [
                    'to' => 'asignatura.index',
                    'active' => request()->is('mantenimientos/asignatura'),
                    'label' => 'Asignaturas',
                    'permissions' => ['ASIGNATURAS_VER'],
                ],
                [
                    'to' => 'ciclos.index',
                    'active' => request()->is('mantenimientos/ciclos'),
                    'label' => 'Ciclos',
                    'permissions' => ['CICLOS_VER'],
                ],
                [
                    'to' => 'recursos.index',
                    'active' => request()->is('mantenimientos/recursos'),
                    'label' => 'Recursos',
                    'permissions' => ['RECURSOS_VER'],
                ],
                [
                    'to' => 'unidades-medida.index',
                    'active' => request()->is('mantenimientos/unidades-medida'),
                    'label' => 'Unidades de medida',
                    'permissions' => ['UNIDADES_MEDIDA_VER'],
                ],
                [
                    'to' => 'tiposBienes.index',
                    'active' => request()->is('mantenimientos/tipos-bienes'),
                    'label' => 'Tipos de bienes',
                    'permissions' => ['TIPOS_BIENES_VER'],
                ],
                [
                    'to' => 'bienes.index',
                    'active' => request()->is('mantenimientos/bienes'),
                    'label' => 'Bienes',
                    'permissions' => ['BIENES_VER'],
                ],
            ],
        ],
        [
            'type' => 2,
            'id' => 'auditorias-dropdown',
            'active' => request()->is('bitacora'),
            'icon' => 'heroicon-s-book-open',
            'label' => 'Bitácora',
            'permissions' => ['BITACORA_VER'],
            'items' => [
                [
                    'to' => 'general.index',
                    'active' => request()->is('bitacora'),
                    'label' => 'General',
                    'permissions' => ['BITACORA_VER'],
                ],
            ],
        ],
        [
            'type' => 2,
            'id' => 'estadisticas-dropdown',
            'active' => request()->is('estadisticas/*'),
            'icon' => 'heroicon-s-chart-bar-square',
            'label' => 'Estadísticas',
            'permissions' => ['BITACORA_VER'],
            'items' => [
                [
                    'to' => 'estadisticas.index',
                    'active' => request()->is('estadisticas/'),
                    'label' => 'Estadíticas y graficos',
                    'permissions' => ['BITACORA_VER'],
                ],
            ],
        ],
    ];
@endphp

<aside id="logo-sidebar"
       class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full border-r border-gray-200 bg-white pt-24 transition-transform dark:border-gray-700 dark:bg-gray-800 lg:translate-x-0">
    <div class="h-full overflow-y-auto bg-white px-3 pb-4 dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @foreach ($sidebarItems as $sit)
                @if (
                    !$sit['permissions'] ||
                        auth()->user()->canany($sit['permissions']))
                    @if ($sit['type'] === 1)
                        <x-aside.base :to="$sit['to']" :active="$sit['active']" :icon="$sit['icon']"
                                      :label="$sit['label']"/>
                    @elseif ($sit['type'] === 2)
                        <x-aside.dropdown id="{{ $sit['id'] }}" :active="$sit['active']" :icon="$sit['icon']"
                                          :label="$sit['label']"/>
                        <ul id="{{ $sit['id'] }}" class="{{ $sit['active'] ? '' : 'hidden'}} space-y-2 py-2">
                            @foreach ($sit['items'] as $item)
                                @if (
                                    !$item['permissions'] ||
                                        auth()->user()->canany($item['permissions']))
                                    <x-aside.dropdown-item :to="$item['to']" :active="$item['active']"
                                                           :label="$item['label']"/>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                @endif
            @endforeach
        </ul>
    </div>
</aside>
