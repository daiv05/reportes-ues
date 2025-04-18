@php
    $headersRoles = [
        ['text' => 'Rol', 'align' => 'left'],
        ['text' => 'Tipo', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
    ];

    $headersPuestos = [
        ['text' => 'Entidad', 'align' => 'left'],
        ['text' => 'Puesto', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acciones', 'align' => 'center'],
    ];

    $headersReports = [
        ['text' => 'Título', 'align' => 'left'],
        ['text' => 'Fecha y Hora', 'align' => 'left'],
        ['text' => 'Tiempo de resolución', 'align' => 'center'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acciones', 'align' => 'center'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Detalles del usuario {{ ucwords(strtolower($user->persona->nombre)) }}" />
    </x-slot>

    <x-container>
        <!-- Información del usuario -->
        <x-view.description-list title="Información del usuario" description="Detalles del usuario y roles asignados."
            :columns="1">
            <x-view.description-list-item label="Nombre completo">
                {{ ucwords(strtolower($user->persona->nombre . ' ' . $user->persona->apellido)) }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Correo electrónico">
                {{ $user->email }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Nombre de usuario">
                {{ $user->carnet }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Tipo de usuario">
                {{ $user->es_estudiante ? 'Estudiante' : 'Empleado' }}
            </x-view.description-list-item>

            @if ($user->es_estudiante)
                <x-view.description-list-item label="Escuela">
                    {{ $user->escuela->nombre }}
                </x-view.description-list-item>

                <x-view.description-list-item label="Facultad">
                    {{ $user->escuela->facultad->nombre }}
                </x-view.description-list-item>
            @endif

            <x-view.description-list-item label="Estado">
                <div class="flex justify-start">
                    <x-status.is-active :active="$user->activo" />
                </div>
            </x-view.description-list-item>

            <x-view.description-list-item label="Fecha de creación">
                {{ $user->created_at->format('d/m/Y H:i:s') }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Última modificación">
                {{ $user->updated_at->format('d/m/Y H:i:s') }}
            </x-view.description-list-item>
        </x-view.description-list>

        <!-- Lista de roles asignados -->
        <div class="mt-6 overflow-hidden bg-white text-center shadow sm:rounded-lg">
            <div class="bg-gray-100 px-4 py-2 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Roles asignados</h3>
            </div>

            <div class="overflow-auto border-t border-gray-200">
                <x-table.base :headers="$headersRoles">
                    @if ($user->roles->isEmpty())
                        <x-table.td colspan="{{ count($headersRoles) }}" justify="center">
                            <span class="text-gray-500">No se encontraron registros</span>
                        </x-table.td>
                    @endif

                    @foreach ($user->roles as $role)
                        <x-table.tr>
                            <x-table.td>{{ $role->name }}</x-table.td>
                            <x-table.td>{{ $role->guard_name }}</x-table.td>
                            <x-table.td justify="center">
                                <x-status.is-active :active="$role->activo" />
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </x-table.base>
            </div>
        </div>

        @if (!$user->es_estudiante)
            <div class="mt-6 overflow-x-auto bg-white text-center shadow sm:rounded-lg">
                <div class="bg-gray-100 px-4 py-2 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Puestos asignados</h3>
                </div>

                <div class="overflow-x-auto border-t border-gray-200">
                    <x-table.base :headers="$headersPuestos">
                        @if ($user->empleadosPuestos->isEmpty())
                            <x-table.td colspan="{{ count($headersPuestos) }}" justify="center">
                                <span class="text-gray-500">No se encontraron registros</span>
                            </x-table.td>
                        @endif

                        @foreach ($user->empleadosPuestos as $empPuesto)
                            <x-table.tr>
                                <x-table.td>{{ $empPuesto->puesto->entidad->nombre }}</x-table.td>
                                <x-table.td>{{ $empPuesto->puesto->nombre }}</x-table.td>
                                <x-table.td justify="center">
                                    <x-status.is-active :active="$empPuesto->activo" />
                                </x-table.td>
                                <x-table.td justify="center">
                                    <div class="relative flex justify-center space-x-2">
                                        <a href="{{ route('empleadosPuestos.show', ['id' => $empPuesto->id]) }}"
                                            data-tooltip-target="tooltip-view-puesto-{{ $empPuesto->id }}"
                                            class="view-button font-medium text-blue-600 hover:underline dark:text-blue-400">
                                            <x-heroicon-o-eye class="h-5 w-5" />
                                        </a>
                                        <div id="tooltip-view-puesto-{{ $empPuesto->id }}" role="tooltip"
                                            class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-blue-700 px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700">
                                            Ver puesto asignado
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </div>
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </x-table.base>
                </div>
            </div>

            <div class="mt-6 overflow-hidden bg-white text-center shadow sm:rounded-lg">
                <div class="bg-gray-100 px-4 py-2 sm:px-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Reportes asignados</h3>
                </div>

                <div class="overflow-auto border-t border-gray-200">
                    <x-table.base :headers="$headersReports">
                        @foreach ($user->empleadosPuestos as $empPuesto)
                            @if ($empPuesto->activo)
                                @if ($empPuesto->empleadosAcciones->isEmpty())
                                    <x-table.td colspan="{{ count($headersReports) }}" justify="center">
                                        <span class="text-gray-500">No se encontraron registros</span>
                                    </x-table.td>
                                @endif

                                @foreach ($empPuesto->empleadosAcciones as $empAccion)
                                    <x-table.tr>
                                        <x-table.td>{{ $empAccion->reporte->titulo }}</x-table.td>
                                        <x-table.td>
                                            {{ \Carbon\Carbon::parse($empAccion->reporte->fecha_reporte . ' ' . $empAccion->reporte->hora_reporte)->format('d/m/Y, h:i A') }}
                                        </x-table.td>
                                        <x-table.td justify="center">
                                            {{ $empAccion->reporte->tiempo_resolucion ?? '-' }}
                                        </x-table.td>
                                        <x-table.td justify="center">
                                            <x-status.chips :text="$empAccion->reporte->estado_ultimo_historial?->nombre ??
                                                'NO ASIGNADO'" class="mb-2" />
                                        </x-table.td>
                                        <x-table.td justify="center">
                                            <div class="relative flex justify-center space-x-2">
                                                <a href="{{ route('detalle-reporte', ['id' => $empAccion->reporte->id]) }}"
                                                    data-tooltip-target="tooltip-view-{{ $empAccion->reporte->id }}"
                                                    class="font-medium text-gray-700 hover:underline">
                                                    <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                                                    </svg>
                                                </a>

                                                <div id="tooltip-view-{{ $empAccion->reporte->id }}" role="tooltip"
                                                    class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-gray-800 px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700">
                                                    Ver detalle del reporte
                                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                                </div>
                                            </div>
                                        </x-table.td>
                                    </x-table.tr>
                                @endforeach
                            @endif
                        @endforeach
                    </x-table.base>
                </div>
            </div>
        @endif
    </x-container>
</x-app-layout>
