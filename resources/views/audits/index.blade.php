<x-app-layout>
    <x-slot name="header">
        <div class="p-6 text-2xl font-bold text-red-900 dark:text-gray-100">
            {{ __('Registros de Auditoría de Usuarios') }}
        </div>
    </x-slot>

    <div class="container mx-auto p-4">

        <!-- Filtros de búsqueda -->
        <div class="mb-4 flex justify-between items-center">
            <form action="{{ route('adUser.index') }}" method="GET" class="flex space-x-4">
                <!-- Filtro por modelo -->
                <!-- Filtro por modelo -->
                <div>
                    <label for="model" class="block text-sm font-medium text-gray-700">Filtrar por Modelo</label>
                    <select name="model" id="model"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Seleccione un Modelo</option>
                        @foreach ($models as $model)
                            <option value="{{ $model->auditable_type }}"
                                {{ request('model') == $model->auditable_type ? 'selected' : '' }}>
                                {{ class_basename($model->auditable_type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro por acción -->
                <div>
                    <label for="event" class="block text-sm font-medium text-gray-700">Filtrar por Acción</label>
                    <select name="event" id="event"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Seleccione una Acción</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->event }}"
                                {{ request('event') == $event->event ? 'selected' : '' }}>
                                {{ ucfirst($event->event) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Botón de búsqueda -->
                <div class="pt-6">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Filtrar</button>
                </div>
            </form>
        </div>

        <!-- Tabla de auditoría, agrupada por acción -->
        <div class="overflow-x-auto">
            @foreach ($events as $event)
                @php
                    // Filtramos las auditorías por la acción
                    $filteredAudits = $audits->where('event', $event->event);
                    if ($filteredAudits->isEmpty()) continue;
                @endphp

                <h3 class="text-lg font-semibold my-4">Acción: {{ ucfirst($event->event) }}</h3>

                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md mb-6">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Campo</th>

                            <!-- Dinámicamente mostramos los campos de cada auditoría (valores antiguos y nuevos) -->
                            @php
                                // Unificar todos los campos para que no haya duplicados
                                $fields = [];
                                foreach ($filteredAudits as $audit) {
                                    $old_values = is_string($audit->old_values) ? json_decode($audit->old_values, true) : $audit->old_values;
                                    $new_values = is_string($audit->new_values) ? json_decode($audit->new_values, true) : $audit->new_values;
                                    $old_values = $old_values ?? [];
                                    $new_values = $new_values ?? [];
                                    $fields = array_merge($fields, array_keys($old_values), array_keys($new_values));
                                }
                                // Eliminamos duplicados
                                $fields = array_unique($fields);
                            @endphp

                            @foreach ($fields as $field)
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">{{ ucfirst($field) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <!-- Mostrar auditorías en filas separadas -->
                        @foreach ($filteredAudits as $audit)
                            @php
                                $old_values = is_string($audit->old_values) ? json_decode($audit->old_values, true) : $audit->old_values;
                                $new_values = is_string($audit->new_values) ? json_decode($audit->new_values, true) : $audit->new_values;
                                $old_values = $old_values ?? [];
                                $new_values = $new_values ?? [];
                            @endphp

                            <!-- Fila de Datos Viejos -->
                            <tr>
                                <td class="px-6 py-4 text-gray-700">Datos Viejos</td>
                                @foreach ($fields as $field)
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $old_values[$field] ?? 'No disponible' }}
                                    </td>
                                @endforeach
                            </tr>

                            <!-- Fila de Datos Nuevos -->
                            <tr>
                                <td class="px-6 py-4 text-gray-700">Datos Nuevos</td>
                                @foreach ($fields as $field)
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $new_values[$field] ?? 'No disponible' }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $audits->links() }}
        </div>

    </div>

    <script>
        // Usamos AJAX para actualizar el filtro de eventos según el modelo seleccionado
        document.getElementById('model').addEventListener('change', function() {
            var model = this.value;

            if (model) {
                // Hacer la solicitud AJAX para obtener los eventos correspondientes
                fetch(`/auditorias/get-events?model=${model}`)
                    .then(response => response.json())
                    .then(data => {
                        // Actualizar el selector de eventos
                        var eventSelect = document.getElementById('event');
                        eventSelect.innerHTML =
                            '<option value="">Seleccione una Acción</option>'; // Limpiar las opciones anteriores

                        data.forEach(event => {
                            var option = document.createElement('option');
                            option.value = event.event;
                            option.textContent = event.event.charAt(0).toUpperCase() + event.event
                                .slice(1); // Capitalizar el evento
                            eventSelect.appendChild(option);
                        });
                    });
            } else {
                // Si no se selecciona modelo, limpiar las opciones de eventos
                document.getElementById('event').innerHTML = '<option value="">Seleccione una Acción</option>';
            }
        });
    </script>
</x-app-layout>
