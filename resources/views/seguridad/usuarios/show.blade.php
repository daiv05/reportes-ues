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

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Información del usuario -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-3 sm:px-6 bg-gray-100">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Información del usuario</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles del usuario y roles asignados.</p>
            </div>

            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-white px-4 py-6 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                        <!-- Primera columna -->
                        <dt class="text-sm font-medium text-gray-500">Nombre completo</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0">{{ $user->persona->nombre }}
                            {{ $user->persona->apellido }}</dd>

                        <!-- Segunda columna -->
                        <dt class="text-sm font-medium text-gray-500">Correo electrónico</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0">{{ $user->email }}</dd>

                        <!-- Tercera columna -->
                        <dt class="text-sm font-medium text-gray-500">Carnet</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0">{{ $user->carnet }}</dd>

                        <!-- Primera columna -->
                        <dt class="text-sm font-medium text-gray-500">Fecha de creación</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0">{{ $user->created_at->format('d/m/Y H:i:s') }}
                        </dd>

                        <!-- Segunda columna -->
                        <dt class="text-sm font-medium text-gray-500">Última modificación</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0">{{ $user->updated_at->format('d/m/Y H:i:s') }}
                        </dd>


                    </div>
                </dl>
            </div>

        </div>


        <!-- Lista de roles asignados -->
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg text-center">
            <div class="px-4 py-2 sm:px-6 bg-gray-100">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Roles asignados</h3>
            </div>

            <div class="border-t border-gray-200">
                <x-table.base :headers="$headers">
                    @foreach ($user->roles as $role)
                        <x-table.tr>
                            <x-table.td>
                                {{ $role->name }}
                            </x-table.td>
                            <x-table.td>
                                {{ $role->guard_name }}
                            </x-table.td>
                            <x-table.td>
                                <x-status.is-active :active="$role->activo" />
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </x-table.base>
            </div>
        </div>
    </div>

</x-app-layout>
