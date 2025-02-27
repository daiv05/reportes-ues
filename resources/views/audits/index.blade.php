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
                <x-forms.primary-button class="ml-3">Filtrar</x-forms.primary-button>
            </x-forms.button-group>
            <x-forms.row :columns="3">
                <x-forms.select label="Filtrar por Modelo" id="model" name="model" :options="$models->mapWithKeys(
                    fn($model) => [$model->auditable_type => class_basename($model->auditable_type)],
                )"
                    :selected="request('model')" :error="$errors->get('model')" />
                <div>
                    <x-forms.select label="Filtrar por Acción" id="event" name="event" :options="collect($events)->mapWithKeys(
                        fn($event) => [
                            $event['event'] => ucfirst($event['event']),
                        ],
                    )"
                        :value="old('event')" />
                </div>

                <div>
                    <x-forms.input-label for="titulo" :value="__('Nombre')" />
                    <div class="relative">
                        <div
                            class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3 rtl:right-0">
                            <svg class="h-4 w-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input type="text" id="table-search" name="titulo" value="{{ request('titulo') }}"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 ps-10 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-red-500 dark:focus:ring-red-500 sm:w-80"
                            placeholder="Buscar por nombre" />
                    </div>
                    <x-forms.input-error :messages="$errors->get('titulo')" class="mt-2" />
                </div>
            </x-forms.row>
            <x-forms.row :columns="2">
                <div>
                    <x-forms.input-label for="start_date" :value="__('Fecha Inicial')" />
                    <div class="relative max-w-sm">
                        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input datepicker datepicker-format="dd/mm/yyyy"  name="start_date" id="start_date" type="text"
                             value="{{ old('start_date') ? old('start_date') : (request('start_date') ?: '') }}"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-red-500 dark:focus:ring-red-500"
                            placeholder="Seleccione una fecha" />
                    </div>
                    <x-forms.input-error :messages="$errors->get('start_date')" class="mt-2" />
                </div>

                <div>
                    <x-forms.input-label for="end_date" :value="__('Fecha Final')" />
                    <div class="relative max-w-sm">
                        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
                            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input datepicker name="end_date" datepicker-format="dd/mm/yyyy" id="end_date" type="text"    value="{{ old('end_date') ? old('end_date') : (request('end_date') ?: '') }}"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-red-500 dark:focus:ring-red-500"
                            placeholder="Seleccione una fecha" />
                    </div>
                    <x-forms.input-error :messages="$errors->get('end_date')" class="mt-2" />
                </div>
            </x-forms.row>
        </form>
        <div class="overflow-x-auto">
            <x-table.base :headers="$headers">
                @if ($audits->isEmpty())
                    <x-table.td colspan="{{ count($headers) }}" justify="center">
                        <span class="text-gray-500">No se encontraron registros</span>
                    </x-table.td>
                @endif

                @foreach ($audits as $audi)
                    <x-table.tr>
                        <x-table.td>
                            @php
                                $user = \App\Models\Seguridad\User::find($audi->user_id);
                            @endphp

                            @if (!$user)
                                @php
                                    $user = \App\Models\Seguridad\User::find($audi->auditable_id);
                                @endphp
                            @endif

                            @if ($user)
                                {{ $user->persona->nombre }} {{ $user->persona->apellido }}
                            @endif
                        </x-table.td>
                        <x-table.td>{{ $audi->event }}</x-table.td>
                        <x-table.td justify="center">{{ class_basename($audi->auditable_type) }}</x-table.td>
                        <x-table.td justify="center">{{ $audi->auditable_id }}</x-table.td>
                        <x-table.td justify="center">
                            @if ($audi->new_values && !empty($audi->new_values))
                                <button data-modal-target="modalNuevo-{{ $audi->id }}"
                                    data-modal-toggle="modalNuevo-{{ $audi->id }}" type="button">
                                    <x-heroicon-o-eye class="h-5 w-5" />
                                </button>
                            @else
                                -
                            @endif
                        </x-table.td>
                        <x-table.td justify="center">
                            @if ($audi->old_values && !empty($audi->old_values))
                                <button data-modal-target="modalViejo-{{ $audi->id }}"
                                    data-modal-toggle="modalViejo-{{ $audi->id }}" type="button">
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
        </div>

        <div class="mt-4">
            {{ $audits->appends(request()->query())->links() }}
        </div>
        @foreach ($audits as $audi)
            <!-- Modal para Datos Nuevos -->
            @isset($audi->new_values)
                @if (!empty($audi->new_values))
                    <x-form-modal id="modalNuevo-{{ $audi->id }}" class="hidden">
                        <x-slot name="header">
                            <h3 class="text-2xl font-bold text-escarlata-ues">Datos Nuevos</h3>
                        </x-slot>
                        <x-slot name="body">
                            <pre>{{ json_encode($audi->new_values, JSON_PRETTY_PRINT) }}</pre>
                        </x-slot>
                        <x-slot name="footer">
                            <button data-modal-hide="modalNuevo-{{ $audi->id }}" type="button"
                                class="rounded-lg border bg-gray-700 px-7 py-2.5 text-sm font-medium text-white focus:outline-none">
                                Cerrar
                            </button>
                        </x-slot>
                    </x-form-modal>
                @endif
            @endisset

            <!-- Modal para Datos Viejos -->
            @isset($audi->old_values)
                @if (!empty($audi->old_values))
                    <x-form-modal id="modalViejo-{{ $audi->id }}" class="hidden">
                        <x-slot name="header">
                            <h3 class="text-2xl font-bold text-escarlata-ues">Datos Viejos</h3>
                        </x-slot>
                        <x-slot name="body">
                            <pre>{{ json_encode($audi->old_values, JSON_PRETTY_PRINT) }}</pre>
                        </x-slot>
                        <x-slot name="footer">
                            <button data-modal-hide="modalViejo-{{ $audi->id }}" type="button"
                                class="rounded-lg border bg-gray-700 px-7 py-2.5 text-sm font-medium text-white focus:outline-none">
                                Cerrar
                            </button>
                        </x-slot>
                    </x-form-modal>
                @endif
            @endisset
        @endforeach
    </x-container>

    <script>
        document.getElementById('model').addEventListener('change', function() {
            var model = this.value;
            if (model) {
                fetch(`/bitacora/get-events?model=${model}`)
                    .then((response) => response.json())
                    .then((data) => {
                        var eventSelect = document.getElementById('event');
                        eventSelect.innerHTML = '<option value="">Seleccione una Acción</option>';
                        data.forEach((event) => {
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
    document.querySelectorAll('[data-modal-toggle]').forEach((button) => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
            }
        });
    });

    document.querySelectorAll('[data-modal-hide]').forEach((button) => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal-hide');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
            }
        });
    });
</script>

<script>
    flatpickr("#start_date", {
        dateFormat: "d/m/Y", // Ensure the date format matches the PHP parsing
    });

    flatpickr("#end_date", {
        dateFormat: "d/m/Y", // Ensure the date format matches the PHP parsing
    });
</script>
