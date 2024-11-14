<x-app-layout>
    <x-slot name="header">
        <div class="p-6 text-2xl font-bold text-red-900 dark:text-gray-100">
            {{ __('Registros de Auditoría de Usuarios') }}
        </div>
    </x-slot>

    <div class="container mx-auto p-4">

        <!-- Filtros de búsqueda -->
        <div class="mb-4 flex justify-between items-center">
            <form action="{{ route('audits.index') }}" method="GET" class="flex space-x-4">
                <!-- Filtro por modelo -->
                <div>
                    <label for="model" class="block text-sm font-medium text-gray-700">Filtrar por Modelo</label>
                    <select name="model" id="model" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Seleccione un Modelo</option>
                        <option value="App\Models\User" {{ request('model') == 'App\Models\User' ? 'selected' : '' }}>Usuario</option>
                    </select>
                </div>

                <!-- Filtro por acción -->
                <div>
                    <label for="event" class="block text-sm font-medium text-gray-700">Filtrar por Acción</label>
                    <select name="event" id="event" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Seleccione una Acción</option>
                        <option value="created" {{ request('event') == 'created' ? 'selected' : '' }}>Creado</option>
                        <option value="updated" {{ request('event') == 'updated' ? 'selected' : '' }}>Actualizado</option>
                        <option value="deleted" {{ request('event') == 'deleted' ? 'selected' : '' }}>Eliminado</option>
                    </select>
                </div>

                <!-- Botón de búsqueda -->
                <div class="pt-6">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Filtrar</button>
                </div>
            </form>
        </div>

        <!-- Tabla de auditoría -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Evento</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Usuario</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Fecha</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">IP</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Navegador</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Antiguos Valores</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Nuevos Valores</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @foreach ($audits as $audit)
                        <tr class="border-t">
                            <td class="px-6 py-4 text-gray-700">{{ $audit->id }}</td>
                            <td class="px-6 py-4 text-gray-700 capitalize">{{ $audit->event }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $audit->user_id ?? 'Usuario no encontrado' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $audit->created_at }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $audit->ip_address }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $audit->user_agent }}</td>

                            <!-- Mostrar valores antiguos -->
                            <td class="px-6 py-4">
                                @php
                                    $old_values = is_string($audit->old_values) ? json_decode($audit->old_values, true) : $audit->old_values;
                                @endphp
                                @if ($old_values && is_array($old_values))
                                    <table class="min-w-full table-auto text-sm">
                                        <tbody>
                                            @foreach ($old_values as $field => $value)
                                                <tr>
                                                    <td class="px-4 py-2 text-gray-600">{{ $field }}</td>
                                                    <td class="px-4 py-2 text-gray-600">{{ $value ?? 'No disponible' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-gray-500">No hay valores anteriores</p>
                                @endif
                            </td>

                            <!-- Mostrar nuevos valores -->
                            <td class="px-6 py-4">
                                @php
                                    $new_values = is_string($audit->new_values) ? json_decode($audit->new_values, true) : $audit->new_values;
                                @endphp
                                @if ($new_values && is_array($new_values))
                                    <table class="min-w-full table-auto text-sm">
                                        <tbody>
                                            @foreach ($new_values as $field => $value)
                                                <tr>
                                                    <td class="px-4 py-2 text-gray-600">{{ $field }}</td>
                                                    <td class="px-4 py-2 text-gray-600">{{ $value ?? 'No disponible' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="text-gray-500">No hay nuevos valores</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $audits->links() }}
        </div>

    </div>
</x-app-layout>
