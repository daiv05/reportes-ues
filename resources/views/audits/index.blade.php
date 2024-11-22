@php
    $headers = [
        ['text' => 'Usuario', 'align' => 'center'],
        ['text' => 'Evento', 'align' => 'center'],
        ['text' => 'Modelo', 'align' => 'center'],
        ['text' => 'id Modelo', 'align' => 'center'],
        ['text' => 'Nuevos datos', 'align' => 'center'],
        ['text' => 'Datos viejos', 'align' => 'center'],
        ['text' => 'URL', 'align' => 'center'],
        ['text' => 'IP', 'align' => 'center'],
        ['text' => 'Navegador', 'align' => 'center'],
        ['text' => 'Creacion', 'align' => 'center'],
        ['text' => 'Actualizacion', 'align' => 'center'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="p-6 text-2xl font-bold text-red-900 dark:text-gray-100">
            {{ __('Registros de Auditoría de Usuarios') }}
        </div>
    </x-slot>

    <x-container>
        <form action="{{ route('general.index') }}" method="GET">
            <x-forms.button-group>
                <x-forms.primary-button class="ml-3">
                    Filtrar
                </x-forms.primary-button>
            </x-forms.button-group>
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

                <div>
                    <x-forms.input-label for="start_date" :value="__('Fecha Inicial')" />
                    <input type="date" name="start_date" id="start_date"
                        value="{{ old('start_date', request('start_date')) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Seleccione una fecha" />
                    <x-forms.input-error :messages="$errors->get('start_date')" class="mt-2" />
                </div>

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
        <x-table.base :headers="$headers">
            @foreach ($audits as $audi)
                <x-table.tr>
                    <x-table.td>
                        @php
                            $user = \App\Models\Seguridad\User::find($audi->user_id);
                        @endphp
                        {{ $user->persona->nombre }} {{ $user->persona->apellido }}
                    </x-table.td>
                    <x-table.td>{{ $audi->event }}</x-table.td>
                    <x-table.td justify="center">{{ class_basename($audi->auditable_type) }}</x-table.td>
                    <x-table.td justify="center">{{ $audi->auditable_id }}</x-table.td>
                    <x-table.td justify="center">
                        @if ($audi->new_values)
                            <button type="button" data-modal-target="#modalNuevo-{{ $audi->id }}"
                                data-modal-toggle="modalNuevo-{{ $audi->id }}">
                                <x-heroicon-o-eye class="h-5 w-5" />
                            </button>
                        @else
                            -
                        @endif
                    </x-table.td>
                    <x-table.td justify="center">
                        @if ($audi->old_values)
                            <button type="button" data-modal-target="#modalViejo-{{ $audi->id }}"
                                data-modal-toggle="modalViejo-{{ $audi->id }}">
                                <x-heroicon-o-eye class="h-5 w-5" />
                            </button>
                        @else
                            -
                        @endif
                    </x-table.td>
                    <x-table.td>{{ $audi->url }}</x-table.td>
                    <x-table.td>{{ $audi->ip_address }}</x-table.td>
                    <x-table.td justify="center">
                        @php
                            $agent = new Jenssegers\Agent\Agent();
                            $agent->setUserAgent($audi->user_agent);
                            $browser = $agent->browser();
                            $platform = $agent->platform();
                        @endphp
                        {{ $browser }} - {{ $platform }}
                    </x-table.td>
                    <x-table.td>{{ $audi->created_at }}</x-table.td>
                    <x-table.td>{{ $audi->updated_at }}</x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.base>

        <div class="mt-4">
            {{ $audits->appends(request()->query())->links() }}
        </div>
        @foreach ($audits as $audi)
            @if ($audi->new_values)
            <x-form-modal id="modalNuevo-{{ $audi->id }}">
                <x-slot name="header">
                    <h3 class="text-2xl font-bold text-escarlata-ues">Detalles de los Nuevos Valores</h3>
                </x-slot>
                <x-slot name="body">
                    <pre>{{ json_encode($audi->new_values, JSON_PRETTY_PRINT) }}</pre>
                </x-slot>
                <x-slot name="footer">
                    <button data-modal-hide="modalNuevo-{{ $audi->id }}" type="button"
                        class="rounded-lg border bg-gray-700 px-7 py-2.5 text-sm font-medium text-white focus:z-10 focus:outline-none focus:ring-4">
                        Cerrar
                    </button>
                </x-slot>
            </x-form-modal>
            @endif
        @endforeach

        @foreach ($audits as $audi)
            @if ($audi->old_values)
                <x-form-modal id="modalViejo-{{ $audi->id }}">
                    <x-slot name="header">
                        <h3 class="text-2xl font-bold text-escarlata-ues">Detalles de los Valores Viejos</h3>
                    </x-slot>
                    <x-slot name="body">
                        <pre>{{ json_encode($audi->old_values, JSON_PRETTY_PRINT) }}</pre>
                    </x-slot>
                    <x-slot name="footer">
                        <button data-modal-hide="modalViejo-{{ $audi->id }}" type="button"
                            class="rounded-lg border bg-gray-700 px-7 py-2.5 text-sm font-medium text-white focus:z-10 focus:outline-none focus:ring-4">
                            Cerrar
                        </button>
                    </x-slot>
                </x-form-modal>
            @endif
        @endforeach
    </x-container>

    <script>
        document.getElementById('model').addEventListener('change', function() {
            var model = this.value;
            if (model) {
                fetch(`/auditorias/get-events?model=${model}`)
                    .then(response => response.json())
                    .then(data => {
                        var eventSelect = document.getElementById('event');
                        eventSelect.innerHTML =
                            '<option value="">Seleccione una Acción</option>';
                        data.forEach(event => {
                            var option = document.createElement('option');
                            option.value = event.event;
                            option.textContent = event.event.charAt(0).toUpperCase() + event.event
                                .slice(1);
                            eventSelect.appendChild(option);
                        });
                    });
            } else {
                document.getElementById('event').innerHTML = '<option value="">Seleccione una Acción</option>';
            }
        });
    </script>
</x-app-layout>
<script>
    // Ensuring modals are initialized properly
    document.querySelectorAll('[data-modal-target]').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.querySelector(modalId);

            if (modal) {
                modal.classList.remove('hidden'); // Show modal
                modal.classList.add('block'); // Add active class
            }
        });
    });

    // Close modal event
    document.querySelectorAll('[data-modal-hide]').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-hide');
            const modal = document.querySelector(modalId);

            if (modal) {
                modal.classList.add('hidden'); // Hide modal
                modal.classList.remove('block'); // Remove active class
            }
        });
    });
</script>
