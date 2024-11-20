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
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Detalles del usuario {{ ucwords(strtolower($user->persona->nombre)) }}" />
    </x-slot>

    <x-container>
        <!-- Información del usuario -->
        <x-view.description-list title="Información del usuario" description="Detalles del usuario y roles asignados." :columns="1">
            <x-view.description-list-item label="Nombre completo">
                {{ ucwords(strtolower($user->persona->nombre. ' '. $user->persona->apellido)) }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Correo electrónico">
                {{ $user->email }}
            </x-view.description-list-item>

            {{-- <x-view.description-list-item label="Entidad relacionada">
                {{ $user->empleadosPuestos[0]->puesto->entidad->nombre }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Puesto">
                {{ $user->empleadosPuestos[0]->puesto->nombre }}
            </x-view.description-list-item> --}}

            <x-view.description-list-item label="Carnet">
                {{ $user->carnet }}
            </x-view.description-list-item>

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
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg text-center">
            <div class="px-4 py-2 sm:px-6 bg-gray-100">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Roles asignados</h3>
            </div>

            <div class="border-t border-gray-200">
                <x-table.base :headers="$headersRoles">
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

        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg text-center">
            <div class="px-4 py-2 sm:px-6 bg-gray-100">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Puestos asignados</h3>
            </div>

            <div class="border-t border-gray-200">
                <x-table.base :headers="$headersPuestos">
                    @foreach ($user->empleadosPuestos as $empPuesto)
                    <x-table.tr>
                        <x-table.td>{{ $empPuesto->puesto->entidad->nombre }}</x-table.td>
                        <x-table.td>{{ $empPuesto->puesto->nombre }}</x-table.td>
                        <x-table.td justify="center">
                            <x-status.is-active :active="$empPuesto->activo" />
                        </x-table.td>
                        <x-table.td justify="center">
                            <div class="flex flex-wrap justify-center gap-2">
                                <a href="{{ url('rhu/empleados-puestos/' . $empPuesto->id) }}"
                                    class="view-button font-medium text-blue-600 hover:underline dark:text-blue-400">
                                    <x-heroicon-o-eye class="h-5 w-5" />
                                </a>
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
                </x-table.base>
            </div>
        </div>
    </x-container>
</x-app-layout>

