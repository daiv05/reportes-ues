@php
    $headers = [
        ['text' => 'Nombre', 'align' => 'left'],
        ['text' => 'Usuario', 'align' => 'left'],
        ['text' => 'Email', 'align' => 'left'],
        ['text' => 'Roles', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acciones', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de Usuarios" />
        <div class="p-6">
            @canany(['USUARIOS_CREAR'])
                <x-forms.primary-button
                    class="block"
                    type="button"
                    id="add-button"
                    onclick="window.location.href='{{ url('seguridad/usuarios/create') }}'"
                >
                    Añadir
                </x-forms.primary-button>
            @endcanany
        </div>
    </x-slot>
    <x-container>
        {{-- Filtros --}}
        <div
            class="flex w-full flex-col flex-wrap items-center justify-between space-y-4 pb-4 sm:flex-row sm:space-y-0"
        >
            <form
                action="{{ route('usuarios.index') }}"
                method="GET"
                class="mt-4 flex w-full flex-row flex-wrap items-center space-x-8"
            >
                <div class="flex w-full flex-col px-4 md:w-5/6 md:px-0">
                    <x-forms.row :columns="3">
                        <x-forms.field id="" label="Nombre" name="nombre-filter" :value="request('nombre-filter')" />

                        <x-forms.field
                            id="email"
                            label="Correo Electrónico"
                            name="email-filter"
                            :value="request('email-filter')"
                        />

                        <x-forms.select
                            name="role-filter"
                            label="Rol"
                            :options="$roles"
                            selected="{{ request('role-filter') }}"
                        />
                    </x-forms.row>
                </div>
                <div class="flex flex-wrap space-x-4">
                    <button
                        type="submit"
                        data-tooltip-target="tooltip-aplicar-filtros"
                        class="inline-flex items-center rounded-full border border-transparent bg-escarlata-ues px-3 py-3 align-middle text-sm font-medium text-white shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-4 w-4"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
                            />
                        </svg>
                    </button>

                    <div
                        id="tooltip-aplicar-filtros"
                        role="tooltip"
                        class="shadow-xs tooltip z-40 inline-block rounded-lg bg-escarlata-ues px-3 py-2 text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                    >
                        Aplicar filtros
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>

                    <button
                        type="reset"
                        data-tooltip-target="tooltip-limpiar-filtros"
                        class="inline-flex items-center rounded-full border border-gray-500 bg-white px-3 py-3 align-middle text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                        onclick="window.location.href='{{ route('usuarios.index') }}';"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-4 w-4"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div
                        id="tooltip-limpiar-filtros"
                        role="tooltip"
                        class="shadow-xs tooltip z-40 inline-block rounded-lg bg-gray-200 px-3 py-2 text-sm font-medium text-escarlata-ues opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                    >
                        Limpiar filtros
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>
            </form>
        </div>

        {{-- TABLA --}}
        <div class="mx-auto mb-6 flex flex-col overflow-x-auto sm:rounded-lg">
            <x-table.base :headers="$headers">
                @foreach ($usuarios as $usuario)
                    <x-table.tr>
                        <x-table.td>
                            {{ $usuario->persona->nombre . ' ' . $usuario->persona->apellido }}
                        </x-table.td>
                        <x-table.td>
                            {{ $usuario->carnet }}
                        </x-table.td>
                        <x-table.td>
                            {{ $usuario->email }}
                        </x-table.td>
                        <x-table.td>
                            {{ implode(', ', $usuario->roles->pluck('name')->toArray()) }}
                        </x-table.td>
                        <x-table.td justify="center">
                            <x-status.is-active :active="$usuario->activo" />
                        </x-table.td>
                        <x-table.td>
                            <div class="flex space-x-2">
                                @canany(['USUARIOS_EDITAR'])
                                    <a
                                        href="{{ url('seguridad/usuarios/' . $usuario->id . '/edit') }}"
                                        class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                        data-tooltip-target="tooltip-edit-{{ $usuario->id }}"
                                    >
                                        <x-heroicon-o-pencil class="h-5 w-5" />
                                    </a>

                                    <div
                                        id="tooltip-edit-{{ $usuario->id }}"
                                        role="tooltip"
                                        class="shadow-xs tooltip z-40 inline-block rounded-lg bg-green-700 px-3 py-2 text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                                    >
                                        Editar usuario
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                @endcanany

                                @canany(['USUARIOS_VER'])
                                    <a
                                        href="{{ url('seguridad/usuarios/' . $usuario->id) }}"
                                        data-tooltip-target="tooltip-view-{{ $usuario->id }}"
                                        class="view-button font-medium text-blue-600 hover:underline dark:text-blue-400"
                                    >
                                        <x-heroicon-o-eye class="h-5 w-5" />
                                    </a>

                                    <div
                                        id="tooltip-view-{{ $usuario->id }}"
                                        role="tooltip"
                                        class="shadow-xs tooltip z-40 inline-block rounded-lg bg-blue-700 px-3 py-2 text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                                    >
                                        Ver usuario
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                @endcanany
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.base>
        </div>
        <nav class="flex flex-wrap items-center justify-center pt-4 md:flex-row" aria-label="Table navigation">
            {{ $usuarios->links() }}
        </nav>
    </x-container>
</x-app-layout>
