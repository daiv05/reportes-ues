@php
    $headers = [
        ['text' => 'Actividad', 'align' => 'left'],
        ['text' => 'Asignatura', 'align' => 'left'],
        ['text' => 'Aula', 'align' => 'left'],
        ['text' => 'Modalidad', 'align' => 'left'],
        ['text' => 'Fecha', 'align' => 'left'],
        ['text' => 'Horario', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acciones', 'align' => 'left'],
    ];

    $cicloActivo = \App\Models\Mantenimientos\Ciclo::with('tipoCiclo')
        ->where('activo', 1)
        ->first();
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.main
            tituloMenor="Listado de eventos"
            tituloMayor="DE LA FACULTAD {{ isset($cicloActivo) ? 'CICLO ' . ($cicloActivo->tipoCiclo->nombre === 'SEGUNDO' ? 'II' : 'I') . ' - ' . $cicloActivo->anio : '' }}"
            subtitulo="Mantente pendiente de los ultimos reportes notificados de tu facultad"
        >
            <x-slot name="acciones">
                <div class="flex flex-wrap gap-3">
                    <x-button-redirect to="reportes-generales" label="Ver listado de reportes" />
                    @if (isset($cicloActivo))
                        @canany(['EVENTOS_CREAR'])
                            <x-forms.primary-button
                                data-modal-target="static-modal"
                                data-modal-toggle="static-modal"
                                type="button"
                            >
                                Añadir
                            </x-forms.primary-button>
                        @endcanany

                        <x-button-redirect to="timeline-eventos-evaluaciones" label="Línea de tiempo" />
                    @endif
                </div>
            </x-slot>
        </x-header.main>
    </x-slot>

    <x-container>
        {{-- FILTROS --}}
        <div class="flex-column flex flex-wrap items-center gap-3 space-y-4 pb-4 sm:flex-row sm:space-y-0">
            <div
                class="relative flex w-full flex-col flex-wrap items-center justify-between space-y-4 pb-4 sm:flex-row sm:space-y-0"
            >
                <form
                    action="{{ route('listado-eventos-evaluaciones') }}"
                    method="GET"
                    class="mt-4 flex w-full flex-row flex-wrap items-center space-x-8"
                >
                    <div class="flex w-full flex-col px-4 md:w-5/6 md:px-0">
                        <x-forms.row :columns="2">
                            <x-forms.field
                                id="materia"
                                label="Materia"
                                name="materia-filter"
                                :value="request('materia-filter')"
                            />
                            <x-forms.field
                                id="descripcion"
                                label="Actividad"
                                name="descripcion-filter"
                                :value="request('descripcion-filter')"
                            />
                        </x-forms.row>
                        <x-forms.row :columns="3">
                            <x-forms.field id="aula" label="Aula" name="aula-filter" :value="request('aula-filter')" />

                            <div class="space-y-1">
                                <x-forms.input-label for="fecha" :value="__('Fecha')" />
                                <x-forms.date-input
                                    type="date"
                                    name="fecha-filter"
                                    :value="request('fecha-filter')"
                                    class="mt-1 w-full"
                                />
                            </div>

                            <x-forms.select
                                name="modalidad-filter"
                                label="Modalidad"
                                :options="$modalidades"
                                selected="{{ request('modalidad-filter') }}"
                            />
                        </x-forms.row>
                    </div>
                    <div class="relative flex flex-wrap space-x-4">
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
                            class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-escarlata-ues px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                        >
                            Aplicar filtros
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>

                        <button
                            type="reset"
                            class="inline-flex items-center rounded-full border border-gray-500 bg-white px-3 py-3 align-middle text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                            onclick="window.location.href='{{ route('listado-eventos-evaluaciones') }}';"
                            data-tooltip-target="tooltip-limpiar-filtros"
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
                            class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-gray-200 px-3 py-2 !text-center text-sm font-medium text-escarlata-ues opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                        >
                            Limpiar filtros
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>
                </form>
            </div>
            {{-- TABLA --}}
            <div class="mx-auto mb-6 flex flex-col overflow-x-auto sm:rounded-lg">
                <x-table.base :headers="$headers" id="table-content">
                    @if ($eventos->isEmpty())
                        <x-table.td colspan="{{ count($headers) }}" justify="center">
                            <span class="text-gray-500">No se encontraron registros</span>
                        </x-table.td>
                    @endif

                    @foreach ($eventos as $evento)
                        <x-table.tr>
                            <x-table.td>{{ $evento->descripcion }}</x-table.td>
                            <x-table.td justify="center">
                                {{ $evento->actividad->asignaturas[0]->nombre }}
                            </x-table.td>
                            <x-table.td justify="center">
                                {{
                                    count($evento->actividad->aulas->pluck('nombre')) == 0
                                        ? 'Sin aula'
                                        : $evento->actividad->aulas->pluck('nombre')->implode(', ')
                                }}
                            </x-table.td>
                            <x-table.td justify="center">{{ $evento->actividad->modalidad->nombre }}</x-table.td>
                            <x-table.td>{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</x-table.td>
                            <x-table.td>
                                @if ($evento->actividad->hora_inicio && $evento->actividad->hora_fin)
                                    {{ \Carbon\Carbon::parse($evento->actividad->hora_inicio)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($evento->actividad->hora_fin)->format('H:i') }}
                                @else
                                    <span class="text-gray-500">Sin horario</span>
                                @endif
                            </x-table.td>
                            <x-table.td justify="center">
                                <x-status.is-active :active="$evento->actividad->activo" />
                            </x-table.td>
                            <x-table.td justify="center">
                                <div class="relative flex justify-center space-x-2">
                                    @canany(['EVENTOS_EDITAR'])
                                    <a
                                        href="#"
                                        class="edit-button flex font-medium text-green-600 hover:underline dark:text-green-400"
                                        data-id="{{ $evento->id }}"
                                        data-fecha="{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}"
                                        data-materia="{{ $evento->actividad->asignaturas[0]->nombre }}"
                                        data-aulas="{{ $evento->actividad->aulas->pluck('nombre') }}"
                                        data-hora-inicio="{{ \Carbon\Carbon::parse($evento->actividad->hora_inicio)->format('h:i A') }}"
                                        data-hora-fin="{{ \Carbon\Carbon::parse($evento->actividad->hora_fin)->format('h:i A') }}"
                                        data-asistentes="{{ $evento->cantidad_asistentes }}"
                                        data-modalidad="{{ $evento->actividad->modalidad->id }}"
                                        data-descripcion="{{ $evento->descripcion }}"
                                        data-comentarios="{{ $evento->comentarios }}"
                                        data-estado="{{ $evento->actividad->activo }}"
                                        data-responsable="{{ $evento->actividad->responsable }}"
                                        data-tooltip-target="tooltip-edit-{{ $evento->id }}"
                                    >
                                        <x-heroicon-s-pencil class="h-5 w-5" />
                                    </a>

                                    <div
                                        id="tooltip-edit-{{ $evento->id }}"
                                        role="tooltip"
                                        class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-green-700 px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                                    >
                                        Editar evento
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    @endcanany
                                    <button
                                        href="#"
                                        data-modal-target="static-modal-details"
                                        data-modal-toggle="static-modal-details"
                                        class="details-button flex font-medium text-blue-600 hover:underline dark:text-blue-400"
                                        data-id="{{ $evento->id }}"
                                        data-fecha="{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}"
                                        data-materia="{{ $evento->actividad->asignaturas[0]->nombre }}"
                                        data-aulas="{{ $evento->actividad->aulas->pluck('nombre') }}"
                                        data-hora-inicio="{{ \Carbon\Carbon::parse($evento->actividad->hora_inicio)->format('h:i A') }}"
                                        data-hora-fin="{{ \Carbon\Carbon::parse($evento->actividad->hora_fin)->format('h:i A') }}"
                                        data-asistentes="{{ $evento->cantidad_asistentes }}"
                                        data-modalidad="{{ $evento->actividad->modalidad->id }}"
                                        data-descripcion="{{ $evento->descripcion }}"
                                        data-comentarios="{{ $evento->comentarios }}"
                                        data-estado="{{ $evento->actividad->activo }}"
                                        data-responsable="{{ $evento->actividad->responsable }}"
                                        data-tooltip-target="tooltip-view-{{ $evento->id }}"
                                    >
                                        <x-heroicon-s-eye class="h-5 w-5" />
                                    </button>

                                    <div
                                        id="tooltip-view-{{ $evento->id }}"
                                        role="tooltip"
                                        class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-blue-700 px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                                    >
                                        Ver evento
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    @if ($evento->actividad->activo)
                                        <a
                                            href="{{ route('crear-reporte', ['evento' => $evento->actividad->id]) }}"
                                            class="flex font-medium text-red-700 hover:underline"
                                            data-tooltip-target="tooltip-report-{{ $evento->id }}"
                                        >
                                            <x-heroicon-s-flag class="mx-2 h-4" />
                                        </a>

                                        <div
                                            id="tooltip-report-{{ $evento->id }}"
                                            role="tooltip"
                                            class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-red-700 px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                                        >
                                            Crear reporte
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    @endif
                                </div>
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </x-table.base>
            </div>
            <nav
                class="flex-column flex w-full flex-wrap items-center justify-center pt-4 md:flex-row"
                aria-label="Table navigation"
            >
                {{ $eventos->links() }}
            </nav>
        </div>
    </x-container>

    <x-form-modal id="static-modal-details">
        <x-slot name="header">
            <div class="flex items-center space-x-4">
                <x-heroicon-s-calendar-days class="h-10 w-10 text-escarlata-ues" />
                <div>
                    <h2 id="materia-info" class="text-2xl font-bold text-escarlata-ues"></h2>
                    <h3 class="text-lg font-normal opacity-90">Detalle del evento</h3>
                </div>
            </div>
        </x-slot>
        <x-slot name="body">
            <div class="w-full max-w-4xl overflow-hidden rounded-lg bg-white">
                <div class="bg-primary text-primary-foreground flex flex-col items-center justify-center md:flex-row">
                    <div class="mt-4 flex items-center justify-center space-x-2 md:mt-0">
                        <span
                            id="estado-info"
                            class="flex items-center rounded-full border border-green-600 bg-green-100 px-3 py-1 text-sm font-medium text-green-900"
                        ></span>
                        <span
                            id="modalidad-info"
                            class="rounded-full border border-blue-600 bg-blue-100 px-3 py-1 text-sm font-medium text-blue-900"
                        ></span>
                    </div>
                </div>
                <div class="mt-2 p-1">
                    <div class="grid gap-2 md:grid-cols-2 md:gap-6">
                        <div class="flex items-center space-x-4 p-4">
                            <div class="rounded-full bg-gray-400/20 p-2 text-escarlata-ues">
                                <x-heroicon-s-calendar class="h-5 w-5" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Fecha</p>
                                <p id="fecha-info" class="text-[1.1rem] font-semibold uppercase"></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 p-4">
                            <div class="rounded-full bg-gray-400/20 p-2 text-escarlata-ues">
                                <x-heroicon-s-clock class="h-5 w-5" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Horario</p>
                                <p id="horario-info" class="text-[1.1rem] font-semibold uppercase"></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 p-4">
                            <div class="rounded-full bg-gray-400/20 p-2 text-escarlata-ues">
                                <x-heroicon-s-user-group class="h-5 w-5" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Número de asistentes</p>
                                <p id="asistentes-info" class="text-[1.1rem] font-semibold uppercase"></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 p-4">
                            <div class="rounded-full bg-gray-400/20 p-2 text-escarlata-ues">
                                <x-heroicon-s-map-pin class="h-5 w-5" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Locales</p>
                                <p id="local-info" class="text-[1.1rem] font-semibold uppercase"></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 p-4">
                            <div class="rounded-full bg-gray-400/20 p-2 text-escarlata-ues">
                                <x-heroicon-s-clipboard-document-list class="h-5 w-5" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Evento o evaluación</p>
                                <p id="evento-info" class="text-[1.1rem] font-semibold uppercase"></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 p-4">
                            <div class="rounded-full bg-gray-400/20 p-2 text-escarlata-ues">
                                <x-heroicon-s-user class="h-5 w-5" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Responsable</p>
                                <p id="responsable-info" class="text-[1.1rem] font-semibold uppercase"></p>
                            </div>
                        </div>
                        <div class="col-span-1 flex items-center space-x-4 rounded-xl bg-red-100 p-4 md:col-span-2">
                            <div class="rounded-full bg-gray-400/30 p-2 text-escarlata-ues">
                                <x-heroicon-s-chat-bubble-oval-left-ellipsis class="h-5 w-5" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Comentarios</p>
                                <p id="comentarios-info" class="text-[1rem] font-semibold">Sin comentarios</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <button
                data-modal-hide="static-modal-details"
                type="button"
                class="rounded-lg border bg-gray-700 px-7 py-2.5 text-sm font-medium text-white focus:z-10 focus:outline-none focus:ring-4"
            >
                Salir
            </button>
        </x-slot>
    </x-form-modal>

    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 id="modal-title" class="text-2xl font-bold text-escarlata-ues">Añadir evento o evaluación</h3>
        </x-slot>
        <x-slot name="body">
            <form id="evento-form" method="POST" action="{{ route('evento.store') }}">
                @csrf
                <x-forms.row :columns="2">
                    <input type="hidden" name="id" id="id" />
                    <div class="space-y-1">
                        <x-forms.input-label for="fecha" :value="__('Fecha')" required />
                        <x-forms.date-input
                            id="fecha"
                            type="date"
                            name="fecha"
                            :value="old('fecha')"
                            required
                            class="mt-1 w-full"
                        />
                        <x-forms.input-error :messages="$errors->get('fecha')" class="mt-2" />
                        <div id="fecha-error" class="text-sm text-red-500"></div>
                    </div>

                    {{-- Materia --}}
                    <div class="space-y-1">
                        <x-forms.field
                            label="Materia"
                            name="materia"
                            pattern="^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ]{1,10}$"
                            patternMessage="Solo se permiten 10 caracteres que sean letras y números"
                            type="text"
                            :value="old('materia')"
                            :error="$errors->get('materia')"
                            required
                        />
                        <div id="materia-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="2">
                    <div class="space-y-2">
                        <x-forms.field
                            label="Actividad"
                            name="evaluacion"
                            pattern="^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ ]{1,50}$"
                            patternMessage="Solo se permiten 50 caracteres que sean letras, números o espacios"
                            :value="old('evaluacion')"
                            :error="$errors->get('evaluacion')"
                            required
                        />
                        <div id="evaluacion-error" class="text-sm text-red-500"></div>
                    </div>

                    {{-- Hora Fin --}}
                    <div class="space-y-2">
                        <x-forms.select
                            name="modalidad"
                            :errors="$errors->get('modalidad')"
                            label="Modalidad"
                            :options="$modalidades"
                            :selected="old('modalidad')"
                            required
                        />
                        <div id="modalidad-info" class="text-sm text-gray-500">
                            Se requiere un horario en presencial
                        </div>
                        <div id="modalidad-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="2">
                    <div class="space-y-2">
                        <x-forms.field
                            label="Hora inicio"
                            name="hora_inicio"
                            type="time"
                            :value="old('hora_inicio')"
                            :error="$errors->get('hora_inicio')"
                        />
                        <div id="hora-inicio-error" class="text-sm text-red-500"></div>
                    </div>

                    {{-- Hora Fin --}}
                    <div class="space-y-2">
                        <x-forms.field
                            label="Hora fin"
                            name="hora_fin"
                            type="time"
                            :value="old('hora_fin')"
                            :error="$errors->get('hora_fin')"
                        />
                        <div id="hora-fin-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="2">
                    <div class="space-y-2">
                        <x-forms.field
                            label="Responsable"
                            name="responsable"
                            pattern="^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ ]{1,50}$"
                            patternMessage="Solo se permiten 50 caracteres que sean letras, números, puntos o espacios"
                            :value="old('responsable')"
                            :error="$errors->get('responsable')"
                            required
                        />
                        <div id="responsable-error" class="text-sm text-red-500"></div>
                    </div>

                    {{-- Hora Fin --}}
                    <div class="space-y-2">
                        <x-forms.select
                            name="estado"
                            :errors="$errors->get('estado')"
                            label="Estado"
                            :options="[1 => 'ACTIVO', 0 => 'INACTIVO']"
                            :selected="old('estado', 1)"
                            required
                        />
                        <div id="estado-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="2">
                    <div class="space-y-2">
                        <x-forms.field
                            label="Asistentes"
                            name="asistentes"
                            type="number"
                            :value="old('asistentes')"
                            :error="$errors->get('asistentes')"
                            required
                        />
                        <div id="asistentes-error" class="text-sm text-red-500"></div>
                    </div>
                    <div class="space-y-2">
                        <div class="space-y-1">
                            <x-forms.input-label for="aulas[]" :value="__('Locales')" />
                            <div class="relative">
                                <button
                                    id="dropdownAulasButton"
                                    data-dropdown-toggle="dropdownAulas"
                                    class="w-full rounded-lg border-2 px-4 py-2 text-left text-sm focus:outline-none focus:ring"
                                    type="button"
                                >
                                    Seleccionar aulas
                                </button>

                                <!-- Dropdown de aulas -->
                                <div
                                    id="dropdownAulas"
                                    class="z-20 hidden max-h-[180px] w-full divide-y divide-gray-100 overflow-auto rounded-lg bg-white shadow dark:bg-gray-700"
                                    data-popper-reference-hidden
                                    data-popper-escaped
                                    data-popper-placement="top"
                                >
                                    <ul
                                        class="space-y-2 p-3 text-sm text-gray-700 dark:text-gray-200"
                                        aria-labelledby="dropdownAulasButton"
                                    >
                                        @foreach ($aulas as $aula)
                                            <li class="flex items-center">
                                                <input
                                                    id="checkbox-{{ $aula->nombre }}"
                                                    type="checkbox"
                                                    value="{{ $aula->id }}"
                                                    name="aulas[]"
                                                    class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-blue-500"
                                                    onclick="updateSelectedAulas()"
                                                />
                                                <label
                                                    for="checkbox-{{ $aula->nombre }}"
                                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                >
                                                    {{ $aula->nombre }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <x-forms.input-error :messages="$errors->get('aulas')" class="mt-2" />
                        </div>
                        <div id="aula-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.textarea
                            name="comentario"
                            label="Comentarios"
                            rows="2"
                            pattern="^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ,¡! _-]{1,250}$"
                            patternMessage="Solo se permiten 250 caracteres que sean letras, números, puntos o espacios"
                            :value="old('comentario')"
                            :error="$errors->get('comentario')"
                        />
                    </div>
                </x-forms.row>
            </form>
        </x-slot>
        <x-slot name="footer">
            <button
                data-modal-hide="static-modal"
                type="button"
                class="rounded-lg border bg-gray-700 px-7 py-2.5 text-sm font-medium text-white focus:z-10 focus:outline-none focus:ring-4"
            >
                Cancelar
            </button>
            <button
                type="submit"
                form="evento-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4"
            >
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>

<script>
    const modalidades = @json($modalidades);

    document.getElementById('evento-form').addEventListener('submit', function (event) {
        const materia = document.getElementById('materia').value.trim();
        const estado = document.getElementById('estado').value;
        const fecha = document.getElementById('fecha').value;
        const hora_inicio = document.getElementById('hora_inicio').value;
        const hora_fin = document.getElementById('hora_fin').value;
        const modalidad = document.getElementById('modalidad').value;
        const evaluacion = document.getElementById('evaluacion').value.trim();
        const asistentes = document.getElementById('asistentes').value;
        const aulas = document.querySelectorAll('input[name="aulas[]"]:checked');
        const comentarios = document.getElementById('comentario').value.trim();
        const responsable = document.getElementById('responsable').value.trim();

        const patternErrors = document.querySelectorAll('div[id*="pattern-error"]');

        const aulasArray = [];
        aulas.forEach((aula) => aulasArray.push(aula.value));

        let hasErrors = false;

        if (!materia) {
            hasErrors = true;
            document.getElementById('materia-error').innerHTML = 'El campo materia es obligatorio';
        } else {
            document.getElementById('materia-error').innerHTML = '';
        }

        if (!fecha) {
            hasErrors = true;
            document.getElementById('fecha-error').innerHTML = 'El campo fecha es obligatorio';
        } else {
            document.getElementById('fecha-error').innerHTML = '';
        }

        if (!hora_inicio && modalidad == 2) {
            hasErrors = true;
            document.getElementById('hora-inicio-error').innerHTML =
                'El campo hora inicio es obligatorio en modalida presencial';
        } else {
            document.getElementById('hora-inicio-error').innerHTML = '';
        }

        if (!hora_fin && modalidad == 2) {
            hasErrors = true;
            document.getElementById('hora-fin-error').innerHTML =
                'El campo hora fin es obligatorio en modalidad presencial';
        } else {
            document.getElementById('hora-fin-error').innerHTML = '';
        }

        if (hora_inicio && hora_fin) {
            const inicio = new Date(`01/01/2000 ${hora_inicio}`);
            const fin = new Date(`01/01/2000 ${hora_fin}`);

            if (inicio >= fin) {
                hasErrors = true;
                document.getElementById('hora-inicio-error').innerHTML =
                    'La hora de inicio debe ser menor a la hora de fin';
                document.getElementById('hora-fin-error').innerHTML =
                    'La hora de fin debe ser mayor a la hora de inicio';
            } else {
                document.getElementById('hora-inicio-error').innerHTML = '';
                document.getElementById('hora-fin-error').innerHTML = '';
            }
        }

        if (!modalidad) {
            hasErrors = true;
            document.getElementById('modalidad-error').innerHTML = 'El campo modalidad es obligatorio';
            document.getElementById('modalidad-info').innerHTML = '';
        } else if (modalidad == 2 && (!hora_inicio || !hora_fin)) {
            hasErrors = true;
            document.getElementById('modalidad-info').innerHTML = 'Se requiere un horario en modalidad presencial';
            document.getElementById('modalidad-error').innerHTML = '';
        } else {
            document.getElementById('modalidad-info').innerHTML = '';
            document.getElementById('modalidad-error').innerHTML = '';
        }

        if (!evaluacion) {
            hasErrors = true;
            document.getElementById('evaluacion-error').innerHTML =
                'El campo de la actividad o evaluacion es obligatorio';
        } else {
            document.getElementById('evaluacion-error').innerHTML = '';
        }

        if (!asistentes) {
            hasErrors = true;
            document.getElementById('asistentes-error').innerHTML = 'El campo asistentes es obligatorio';
        } else if (asistentes < 1) {
            hasErrors = true;
            document.getElementById('asistentes-error').innerHTML = 'El evento debe tener al menos un asistente';
        } else {
            document.getElementById('asistentes-error').innerHTML = '';
        }

        if (!aulas.length && aulasArray.length < 1 && modalidad == 2) {
            hasErrors = true;
            document.getElementById('aula-error').innerHTML = 'Debe seleccionar al menos un aula';
        } else {
            document.getElementById('aula-error').innerHTML = '';
        }

        if (!responsable) {
            hasErrors = true;
            document.getElementById('responsable-error').innerHTML = 'El campo responsable es obligatorio';
        } else {
            document.getElementById('responsable-error').innerHTML = '';
        }

        if (!estado) {
            hasErrors = true;
            document.getElementById('estado-error').innerHTML = 'El campo estado es obligatorio';
        } else {
            document.getElementById('estado-error').innerHTML = '';
        }

        if (hasErrors) {
            event.preventDefault();
        }

        if (patternErrors.length > 0) {
            event.preventDefault();
        }
    });

    document.querySelectorAll('[data-modal-hide="static-modal"]').forEach((button) => {
        button.addEventListener('click', function () {
            updateTitle('Añadir evento o evaluación');

            document.getElementById('evento-form').action = '{{ route('evento.store') }}';
            document.getElementById('evento-form').method = 'POST';
            let method = document.querySelector('[name="_method"]');
            if (method) document.getElementById('evento-form').removeChild(method);

            document.querySelectorAll('_method').forEach((input) => input.remove());

            document.getElementById('evento-form').reset();
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
            updateSelectedAulas();
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function (event) {
            const id = this.getAttribute('data-id');
            const materia = this.getAttribute('data-materia');
            const fecha = this.getAttribute('data-fecha');
            const hora_inicio = this.getAttribute('data-hora-inicio');
            const hora_fin = this.getAttribute('data-hora-fin');
            const modalidad = this.getAttribute('data-modalidad');
            const evaluacion = this.getAttribute('data-descripcion');
            const asistentes = this.getAttribute('data-asistentes');
            const aulas = JSON.parse(this.getAttribute('data-aulas'));
            const estado = this.getAttribute('data-estado');
            const responsable = this.getAttribute('data-responsable');
            const comentarios = this.getAttribute('data-comentarios');

            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));

            updateTitle('Editar evento o evaluación');

            // Ajustar el formulario para la edición
            document.getElementById('evento-form').action = `{{ route('evento.update', ':id') }}`.replace(':id', id);
            document.getElementById('evento-form').method = 'POST';
            if (!document.querySelector('input[name="_method"]')) {
                document
                    .getElementById('evento-form')
                    .insertAdjacentHTML('beforeend', '<input type="hidden" name="_method" value="PUT">');
            }

            // Asignar los valores al formulario
            document.getElementById('materia').value = materia;
            document.getElementById('hora_inicio').value = document.getElementById('fecha').value = fecha;
            document.getElementById('hora_inicio').value = hora_inicio;
            document.getElementById('hora_fin').value = hora_fin;
            document.getElementById('modalidad').value = modalidad;
            document.getElementById('evaluacion').value = evaluacion;
            document.getElementById('asistentes').value = asistentes;
            document.getElementById('estado').value = estado;
            document.getElementById('responsable').value = responsable;

            if (aulas.length > 0) {
                aulas.forEach((aula) => {
                    document.getElementById(`checkbox-${aula}`).checked = true;
                });
            }
            updateSelectedAulas();

            document.getElementById('comentario').value = comentarios;

            // Abrir el modal
            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });

    document.querySelectorAll('.details-button').forEach((button) => {
        button.addEventListener('click', function (event) {
            const materia = this.getAttribute('data-materia'); //
            const fecha = this.getAttribute('data-fecha');
            const hora_inicio = this.getAttribute('data-hora-inicio'); //
            const hora_fin = this.getAttribute('data-hora-fin'); //
            const modalidad = this.getAttribute('data-modalidad'); //
            const evaluacion = this.getAttribute('data-descripcion');
            const asistentes = this.getAttribute('data-asistentes'); //
            const aulas = JSON.parse(this.getAttribute('data-aulas')); //
            const estado = this.getAttribute('data-estado'); //
            const responsable = this.getAttribute('data-responsable'); //
            const comentarios = this.getAttribute('data-comentarios');

            document.getElementById('materia-info').textContent = materia;

            if (estado == '1') {
                document.getElementById('estado-info').textContent = 'ACTIVO';
                document.getElementById('estado-info').classList.remove('bg-red-100', 'border-red-600', 'text-red-900');
                document
                    .getElementById('estado-info')
                    .classList.add('bg-green-100', 'border-green-600', 'text-green-900');
            } else {
                document.getElementById('estado-info').textContent = 'INACTIVO';
                document
                    .getElementById('estado-info')
                    .classList.remove('bg-green-100', 'border-green-600', 'text-green-900');
                document.getElementById('estado-info').classList.add('bg-red-100', 'border-red-600', 'text-red-900');
            }

            document.getElementById('modalidad-info').textContent = modalidades[modalidad];

            if (modalidades[modalidad] == 'PRESENCIAL') {
                document
                    .getElementById('modalidad-info')
                    .classList.remove('bg-violet-100', 'border-violet-600', 'text-violet-900');
                document
                    .getElementById('modalidad-info')
                    .classList.add('bg-blue-100', 'border-blue-600', 'text-blue-900');
            } else {
                document
                    .getElementById('modalidad-info')
                    .classList.remove('bg-blue-100', 'border-blue-600', 'text-blue-900');
                document
                    .getElementById('modalidad-info')
                    .classList.add('bg-violet-100', 'border-violet-600', 'text-violet-900');
            }

            document.getElementById('evento-info').textContent = evaluacion;
            document.getElementById('horario-info').textContent =
                hora_inicio != hora_fin ? hora_inicio + ' - ' + hora_fin : '-';
            document.getElementById('asistentes-info').textContent = asistentes + ' asistentes';
            document.getElementById('responsable-info').textContent = responsable;
            document.getElementById('local-info').textContent = aulas.join(', ') || '-';
            document.getElementById('fecha-info').textContent = fecha;
            if (comentarios == '' || comentarios == null) {
                document.getElementById('comentarios-info').textContent = '-';
            } else {
                document.getElementById('comentarios-info').textContent = comentarios;
            }
        });
    });

    function updateTitle(title) {
        document.getElementById('modal-title').textContent = title;
    }
</script>

<script>
    function updateSelectedAulas() {
        const checkboxes = document.querySelectorAll(`#dropdownAulas input[type="checkbox"]`);
        const selected = [];

        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                selected.push(checkbox.nextElementSibling.textContent.trim());
            }
        });

        const button = document.getElementById('dropdownAulasButton');
        button.textContent = selected.length ? selected.join(', ') : 'Seleccionar aulas';
    }
</script>
