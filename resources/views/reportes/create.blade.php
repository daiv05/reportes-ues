<x-app-layout>
    <x-slot name="header">
        <div class="p-6 text-2xl font-bold text-red-900 dark:text-gray-100">
            {{ __('Reportar un problema') }}
        </div>
    </x-slot>

    <div>
        <div>
            <div class="p-6 text-center text-gray-500 dark:text-gray-100">
                {{ 'Fecha y hora actual: ' . \Carbon\Carbon::now()->format('d/m/Y h:i A') }}
            </div>

            <div class="my-8">
                <form id="reporteForm" class="md:mx-16" method="POST" action="{{ route('reportes.store') }}">
                    @csrf
                    <!-- Titulo -->
                    <div class="mb-5">
                        <label for="titulo" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Titulo del reporte
                            <x-forms.input-required />
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
                                <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    viewBox="0 0 14 9" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.833313 1.6V1H1.49998V1.6H0.833313ZM0.833313 4.8V4.2H1.49998V4.8H0.833313ZM0.833313 8V7.4H1.49998V8H0.833313ZM12.8333 1.6H4.49998C4.40514 1.6 4.31808 1.56364 4.25699 1.50499C4.19659 1.44701 4.16665 1.37283 4.16665 1.3C4.16665 1.22717 4.19659 1.15299 4.25699 1.09501C4.31808 1.03636 4.40514 1 4.49998 1H12.8333C12.9282 1 13.0152 1.03636 13.0763 1.09501C13.1367 1.15299 13.1666 1.22717 13.1666 1.3C13.1666 1.37283 13.1367 1.44701 13.0763 1.50499C13.0152 1.56364 12.9282 1.6 12.8333 1.6ZM12.8333 4.8H4.49998C4.40514 4.8 4.31808 4.76364 4.25699 4.70499C4.19659 4.64701 4.16665 4.57283 4.16665 4.5C4.16665 4.42717 4.19659 4.35299 4.25699 4.29501C4.31808 4.23636 4.40514 4.2 4.49998 4.2H12.8333C12.9282 4.2 13.0152 4.23636 13.0763 4.29501C13.1367 4.35299 13.1666 4.42717 13.1666 4.5C13.1666 4.57283 13.1367 4.64701 13.0763 4.70499C13.0152 4.76364 12.9282 4.8 12.8333 4.8ZM12.8333 8H4.49998C4.40514 8 4.31808 7.96364 4.25699 7.90499C4.19659 7.84701 4.16665 7.77283 4.16665 7.7C4.16665 7.62717 4.19659 7.55299 4.25699 7.49501C4.31808 7.43636 4.40514 7.4 4.49998 7.4H12.8333C12.9282 7.4 13.0152 7.43636 13.0763 7.49501C13.1367 7.55299 13.1666 7.62717 13.1666 7.7C13.1666 7.77283 13.1367 7.84701 13.0763 7.90499C13.0152 7.96364 12.9282 8 12.8333 8Z"
                                        fill="#6B7280" stroke="#6B7280" />
                                </svg>
                            </div>
                            <input type="text" id="titulo" name="titulo"
                                class="block w-full rounded-lg border border-gray-300 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                placeholder="Aula sin cuidado..." />
                        </div>
                    </div>
                    <!-- Descripción -->
                    <div class="mb-5">
                        <label for="descripcion" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Descripción
                            <x-forms.input-required />
                        </label>
                        <textarea id="descripcion" name="descripcion" rows="4"
                            class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            placeholder="Se ha observado..."></textarea>
                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="descripcion_hint">
                            Recuerda ser claro y conciso
                        </div>
                    </div>

                    <!-- Actividad a reportar -->
                    @if (isset($clase) || isset($evento))
                        @if (isset($clase))
                            <input type="hidden" id="id_actividad" name="id_actividad"
                                value="{{ $clase->id_actividad }}" />
                        @else
                            <input type="hidden" id="id_actividad" name="id_actividad"
                                value="{{ $evento->id_actividad }}" />
                        @endif
                        <div class="mb-5">
                            <label for="titulo" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                                Actividad seleccionada
                            </label>

                            <div>
                                <table class="text-left text-sm text-gray-500 dark:text-gray-400 rtl:text-right">
                                    @if (isset($clase))
                                        <thead
                                            class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">Asignaturas</th>
                                                <th scope="col" class="px-6 py-3">Aulas</th>
                                                <th scope="col" class="px-6 py-3">Tipo</th>
                                                <th scope="col" class="px-6 py-3">No. de grupo</th>
                                                <th scope="col" class="px-6 py-3">Escuela</th>
                                                <th scope="col" class="px-6 py-3">Horario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <x-table.tr>
                                                <x-table.td>{{ $clase->actividad->asignaturas[0]->nombre }}</x-table.td>
                                                <x-table.td>
                                                    @php
                                                        $aulasClase = '';
                                                        foreach ($clase->actividad->aulas as $aula) {
                                                            $aulasClase .= $aula->nombre . ', ';
                                                        }
                                                        echo rtrim($aulasClase, ', ');
                                                    @endphp
                                                </x-table.td>
                                                <x-table.td>{{ $clase->tipoClase->nombre }}</x-table.td>
                                                <x-table.td>{{ $clase->numero_grupo }}</x-table.td>
                                                <x-table.td>{{ $clase->actividad->asignaturas[0]->escuela->nombre }}</x-table.td>
                                                <x-table.td>
                                                    {{ Carbon\Carbon::parse($clase->actividad->hora_inicio)->format('h:i A') .
                                                        ' - ' .
                                                        Carbon\Carbon::parse($clase->actividad->hora_fin)->format('h:i A') }}</x-table.td>
                                            </x-table.tr>
                                        </tbody>
                                    @else
                                        <thead
                                            class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">Actividad</th>
                                                <th scope="col" class="px-6 py-3">Aulas</th>
                                                <th scope="col" class="px-6 py-3">Modalidad</th>
                                                <th scope="col" class="px-6 py-3">Fecha</th>
                                                <th scope="col" class="px-6 py-3">Horario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <x-table.tr>
                                                <x-table.td>{{ $evento->descripcion }}</x-table.td>
                                                <x-table.td>
                                                    @php
                                                        $aulasEvento = '';
                                                        foreach ($evento->actividad->aulas as $aula) {
                                                            $aulasEvento .= $aula->nombre . ', ';
                                                        }
                                                        echo rtrim($aulasEvento, ', ');
                                                    @endphp
                                                </x-table.td>
                                                <x-table.td>{{ $evento->actividad->modalidad->nombre }}</x-table.td>
                                                <x-table.td>{{ Carbon\Carbon::parse($evento->actividad->fecha)->format('d/m/Y') }}</x-table.td>
                                                <x-table.td>
                                                    {{ Carbon\Carbon::parse($evento->actividad->hora_inicio)->format('h:i A') .
                                                        ' - ' .
                                                        Carbon\Carbon::parse($evento->actividad->hora_fin)->format('h:i A') }}</x-table.td>
                                            </x-table.tr>
                                        </tbody>
                                    @endif

                                </table>
                            </div>
                        </div>
                    @endif

                    <!-- Selección de Aula -->
                    <div class="mb-5">
                        <label for="id_aula" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Lugar
                        </label>
                        <x-forms.search-select id="id_aula" name="id_aula"
                         :options="$aulas" searchable id_key="id" name_key="nombre" />                        
                        {{-- <select id="id_aula" name="id_aula"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            <option value="">Seleccionar instalación</option>
                            @foreach ($aulas as $aula)
                                <option value="{{ $aula->id }}">{{ $aula->nombre }}</option>
                            @endforeach
                        </select> --}}
                        @include('components.forms.input-error', ['messages' => $errors->get('id_aula')])
                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="descripcion_hint">
                            Especifique si considera necesario
                        </div>
                    </div>

                    <div class="flex justify-center pt-4">
                        @canany(['REPORTES_CREAR'])
                            <button type="button"
                                data-modal-target="send-modal" data-modal-toggle="send-modal"
                                class="w-full rounded-lg bg-red-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 sm:w-auto">
                                Enviar reporte
                            </button>
                        @endcanany
                    </div>

                    @include('reportes.partials.modal-confirm-send-report')

                </form>
            </div>
        </div>
    </div>
</x-app-layout>
