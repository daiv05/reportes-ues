@php
    $headersPermissions = [['text' => 'Permiso', 'align' => 'left'], ['text' => 'Estado', 'align' => 'center']];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Detalles del rol {{ ucwords(strtolower($role->name)) }}" />
    </x-slot>

    <x-container>
        <!-- Información del rol -->
        <x-view.description-list
            title="Información del rol"
            description="Detalles del rol y permisos asignados."
            :columns="2"
        >
            <x-view.description-list-item label="Rol">
                {{ ucwords(strtolower($role->name)) }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Sitio">
                {{ $role->guard_name }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Estado">
                <div class="flex justify-start">
                    <x-status.is-active :active="$role->activo" />
                </div>
            </x-view.description-list-item>

            <x-view.description-list-item label="Fecha de creación">
                {{ $role->created_at->format('d/m/Y H:i:s') }}
            </x-view.description-list-item>
        </x-view.description-list>
        <div class="mt-6 overflow-hidden bg-white text-center shadow sm:rounded-lg">
            <div class="bg-gray-100 px-4 py-2 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Permisos asignados</h3>
            </div>

            <div class="border-t border-gray-200">
                <x-table.base :headers="$headersPermissions">
                    @foreach ($permissions as $permission)
                        <x-table.tr>
                            <x-table.td>{{ $permission->name }}</x-table.td>
                            <x-table.td justify="center">
                                <x-heroicon-o-check-circle class="h-5 w-5 text-green-500" />
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </x-table.base>
            </div>

            <nav class="mt-4 flex justify-center">
                {{ $permissions->links() }}
            </nav>
        </div>
    </x-container>
</x-app-layout>
