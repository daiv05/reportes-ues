@php
    $headers = [
        ['text' => 'Nombre', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acción', 'align' => 'left'],
    ];

    $roleRestricted = [1];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de Roles" />
        <div class="p-6">
            @canany(['ROLES_CREAR'])
                <x-forms.primary-button
                    class="block"
                    type="button"
                    id="add-button"
                    onclick="window.location.href='{{ url('seguridad/roles/create') }}'"
                >
                    Añadir
                </x-forms.primary-button>
            @endcanany
        </div>
    </x-slot>
    <x-container>
        <div class="mb-8 overflow-x-auto">
            <x-table.base :headers="$headers">
                @if ($roles->isEmpty())
                    <x-table.td colspan="{{ count($headers) }}" justify="center">
                        <span class="text-gray-500">No se encontraron registros</span>
                    </x-table.td>
                @endif

                @foreach ($roles as $rol)
                    <x-table.tr>
                        <x-table.td>
                            {{ $rol->name }}
                        </x-table.td>
                        <x-table.td justify="center">
                            <x-status.is-active :active="$rol->activo" />
                        </x-table.td>
                        <x-table.td>
                            <div class="relative flex justify-center space-x-2">
                                @if (! in_array($rol->id, $roleRestricted))
                                    @canany(['ROLES_EDITAR'])
                                        <a
                                            href="{{ url('seguridad/roles/' . $rol->id . '/edit') }}"
                                            class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                            data-tooltip-target="tooltip-edit-{{ $rol->id }}"
                                        >
                                            <x-heroicon-o-pencil class="h-5 w-5" />
                                        </a>

                                        <div
                                            id="tooltip-edit-{{ $rol->id }}"
                                            role="tooltip"
                                            class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-green-700 px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                                        >
                                            Editar rol
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    @endcanany
                                @else
                                    <x-heroicon-o-pencil class="h-5 w-5 text-gray-300" />
                                @endif
                                @canany(['ROLES_VER'])
                                    <a
                                        href="{{ url('seguridad/roles/' . $rol->id) }}"
                                        class="view-button font-medium text-blue-600 hover:underline dark:text-blue-400"
                                        data-tooltip-target="tooltip-view-{{ $rol->id }}"
                                    >
                                        <x-heroicon-o-eye class="h-5 w-5" />
                                    </a>

                                    <div
                                        id="tooltip-view-{{ $rol->id }}"
                                        role="tooltip"
                                        class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-blue-700 px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                                    >
                                        Ver rol
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                @endcanany
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.base>
        </div>
        <nav
            class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row"
            aria-label="Table navigation"
        >
            {{ $roles->links() }}
        </nav>
    </x-container>
</x-app-layout>
