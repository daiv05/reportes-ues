<x-app-layout>
    <x-slot name="header">
        <div class="p-6 text-2xl font-bold text-red-900 dark:text-gray-100">
            {{ __('Registros de Auditoría de Usuarios') }}
        </div>
    </x-slot>

    <x-container>
        <form action="{{ route('adUser.index') }}" method="GET">
            <x-forms.button-group>
                <x-forms.primary-button class="ml-3">
                    Filtrar
                </x-forms.primary-button>
            </x-forms.button-group>
            <!-- Filtro por modelo -->
            <x-forms.row :columns="3">
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

                <!-- Filtro por usuario -->
                <div>
                    <x-forms.select label="Filtrar por Usuario" id="user_id" name="user_id" :options="$users->mapWithKeys(
                        fn($user) => [
                            $user->id => ($user->persona->nombre ?? '') . ' ' . ($user->persona->apellido ?? ''),
                        ],
                    )"
                        :value="old('user_id')" :error="$errors->get('user_id')" />
                </div>
            </x-forms.row>
            <x-forms.row :columns="2">
                <!-- Filtro por Fecha Inicial -->
                <div>
                    <x-forms.input-label for="start_date" :value="__('Fecha Inicial')" />
                    <input type="date" name="start_date" id="start_date"
                        value="{{ old('start_date', request('start_date')) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Seleccione una fecha" />
                    <x-forms.input-error :messages="$errors->get('start_date')" class="mt-2" />
                </div>

                <!-- Filtro por Fecha Final -->
                <div>
                    <x-forms.input-label for="end_date" :value="__('Fecha Final')" />
                    <input type="date" name="end_date" id="end_date"
                        value="{{ old('end_date', request('end_date')) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Seleccione una fecha" />
                    <x-forms.input-error :messages="$errors->get('end_date')" class="mt-2" />
                </div>
            </x-forms.row>



        </form>


        <!-- Tabla de auditoría, agrupada por acción -->
        <div class="overflow-x-auto">
            @foreach ($events as $event)
                @php
                    // Filtramos las auditorías por la acción
                    $filteredAudits = $audits->where('event', $event->event);
                    if ($filteredAudits->isEmpty()) {
                        continue;
                    }
                @endphp

                <h3 class="text-lg font-semibold my-4">Acción: {{ ucfirst($event->event) }}</h3>

                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md mb-6">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Campo</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Modificador</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Modificado</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Fecha creacion</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Evento</th>

                            <!-- Dinámicamente mostramos los campos de cada auditoría (valores antiguos y nuevos) -->
                            @php
                                // Unificar todos los campos para que no haya duplicados
                                $fields = [];
                                foreach ($filteredAudits as $audit) {
                                    $old_values = is_string($audit->old_values)
                                        ? json_decode($audit->old_values, true)
                                        : $audit->old_values;
                                    $new_values = is_string($audit->new_values)
                                        ? json_decode($audit->new_values, true)
                                        : $audit->new_values;
                                    $old_values = $old_values ?? [];
                                    $new_values = $new_values ?? [];
                                    $fields = array_merge($fields, array_keys($old_values), array_keys($new_values));
                                }
                                // Eliminamos duplicados
                                $fields = array_unique($fields);
                            @endphp

                            @foreach ($fields as $field)
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">{{ ucfirst($field) }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <!-- Mostrar auditorías en filas separadas -->
                        @foreach ($filteredAudits as $audit)
                            @php
                                $old_values = is_string($audit->old_values)
                                    ? json_decode($audit->old_values, true)
                                    : $audit->old_values;
                                $new_values = is_string($audit->new_values)
                                    ? json_decode($audit->new_values, true)
                                    : $audit->new_values;
                                $old_values = $old_values ?? [];
                                $new_values = $new_values ?? [];

                                // Obtener el usuario que realizó la acción
                                $user = \App\Models\Seguridad\User::find($audit->user_id); // Suponiendo que 'user_id' es el campo en la auditoría
                                $Auiditado = \App\Models\Seguridad\User::find($audit->auditable_id); // Suponiendo que 'user_id' es el campo en la auditoría
                            @endphp

                            <!-- Fila de Datos Viejos -->
                            <tr>
                                <td class="px-6 py-4 text-gray-700">Datos Viejos</td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $user ? $user->persona->nombre : 'Usuario no disponible' }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $user ? $Auiditado->persona->nombre : 'Usuario no disponible' }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ $audit->created_at->format('Y-m-d H:i:s') }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ ucfirst($audit->event) }}</td>
                                @foreach ($fields as $field)
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $old_values[$field] ?? 'Vacio' }}
                                    </td>
                                @endforeach
                            </tr>

                            <!-- Fila de Datos Nuevos -->
                            <tr>
                                <td class="px-6 py-4 text-gray-700">Datos Nuevos</td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $user ? $user->persona->nombre : 'Usuario no disponible' }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $Auiditado ? $Auiditado->persona->nombre : 'Usuario no disponible' }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ $audit->created_at->format('Y-m-d H:i:s') }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">{{ ucfirst($audit->event) }}</td>
                                @foreach ($fields as $field)
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $new_values[$field] ?? 'Vavio' }}
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
            {{ $audits->appends(request()->query())->links() }}
        </div>


    </x-container>

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
