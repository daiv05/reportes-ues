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
            @include('audits.filters')
        </form>
        <div class="overflow-x-auto">
            <x-table.base :headers="$headers">
                @if ($audits->isEmpty())
                    <x-table.td colspan="{{ count($headers) }}" justify="center">
                        <span class="text-gray-500">No se encontraron registros</span>
                    </x-table.td>
                @else
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
                            <x-table.td>{{ \Carbon\Carbon::parse($audi->created_at)->format('d/m/Y H:i:s') }}</x-table.td>
                            <x-table.td>{{ \Carbon\Carbon::parse($audi->updated_at)->format('d/m/Y H:i:s') }}</x-table.td>

                        </x-table.tr>
                    @endforeach
                @endif
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
