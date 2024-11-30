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
    </x-slot>
    <x-container>
        <div class="p-6">
            <x-forms.primary-button class="block" type="button" id="add-button"
                onclick="window.location.href='{{ url('seguridad/usuarios/create') }}'">
                Añadir
            </x-forms.primary-button>
        </div>
        <br>
        <div class="overflow-x-auto">
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
                                <a href="{{ url('seguridad/usuarios/' . $usuario->id . '/edit') }}"
                                    class="edit-button font-medium text-green-600 hover:underline dark:text-green-400">
                                    <x-heroicon-o-pencil class="h-5 w-5" />
                                </a>
                                <a href="{{ url('seguridad/usuarios/' . $usuario->id) }}"
                                    class="view-button font-medium text-blue-600 hover:underline dark:text-blue-400">
                                    <x-heroicon-o-eye class="h-5 w-5" />
                                </a>
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
