@php
    $headers = [
        ['text' => 'Rol', 'align' => 'left'],
        ['text' => 'Tipo', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Detalles del usuario {{ $user->persona->nombre }}" />
    </x-slot>

    <x-container>
        <!-- Información del usuario -->
        <x-view.description-list title="Información del usuario" description="Detalles del usuario y roles asignados." :columns="1">
            <x-view.description-list-item label="Nombre completo">
                {{ $user->persona->nombre }} {{ $user->persona->apellido }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Correo electrónico">
                {{ $user->email }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Carnet">
                {{ $user->carnet }}
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
                <x-table.base :headers="$headers">
                    @foreach ($user->roles as $role)
                        <x-table.tr>
                            <x-table.td>{{ $role->name }}</x-table.td>
                            <x-table.td>{{ $role->guard_name }}</x-table.td>
                            <x-table.td>
                                <x-status.is-active :active="$role->activo" />
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </x-table.base>
            </div>
        </div>
    </x-container>
</x-app-layout>

