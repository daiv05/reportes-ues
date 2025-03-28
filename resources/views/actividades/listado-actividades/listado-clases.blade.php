@php
    $headers = [
        ['text' => 'Asignatura', 'align' => 'left'],
        ['text' => 'Aula', 'align' => 'left'],
        ['text' => 'Modalidad', 'align' => 'left'],
        ['text' => 'Grupo', 'align' => 'center'],
        ['text' => 'Escuela', 'align' => 'left'],
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
            tituloMenor="Listado de clases"
            tituloMayor="DE LA FACULTAD {{ isset($cicloActivo) ? 'CICLO ' . ($cicloActivo->tipoCiclo->nombre === 'SEGUNDO' ? 'II' : 'I') . ' - ' . $cicloActivo->anio : '' }}"
            subtitulo="Mantente pendiente de los ultimos reportes notificados de tu facultad"
        >
            <x-slot name="acciones">
                <div class="flex flex-wrap gap-3">
                    <x-button-redirect to="reportes-generales" label="Ver listado de reportes" />
                    @if (isset($cicloActivo))
                        @canany(['CLASES_CREAR'])
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
                    action="{{ route('listado-clases') }}"
                    method="GET"
                    class="mt-4 flex w-full flex-row flex-wrap items-center space-x-8"
                >
                    <div class="flex w-full flex-col px-4 md:w-5/6 md:px-0">
                        <x-forms.row :columns="2">
                            <x-forms.field
                                id="materia"
                                label="Materia"
                                name="materia-filtro"
                                :value="request('materia-filtro')"
                            />
                            <x-forms.select
                                name="escuela-filtro"
                                label="Escuela"
                                :options="$escuelas"
                                selected="{{ request('escuela-filtro') }}"
                            />
                        </x-forms.row>
                        <x-forms.row :columns="3">
                            <x-forms.field
                                id="aula-filtro"
                                label="Aula"
                                name="aula-filtro"
                                :value="request('aula-filtro')"
                            />

                            <x-forms.select
                                name="tipo-filtro"
                                label="Tipo de clase"
                                :options="$tiposClase"
                                selected="{{ request('tipo-filtro') }}"
                            />

                            <x-forms.select
                                name="modalidad-filtro"
                                label="Modalidad"
                                :options="$modalidades"
                                selected="{{ request('modalidad-filtro') }}"
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
                            onclick="window.location.href='{{ route('listado-clases') }}';"
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
                    @if ($clases->isEmpty())
                        <x-table.td colspan="{{ count($headers) }}" justify="center">
                            <span class="text-gray-500">No se encontraron registros</span>
                        </x-table.td>
                    @endif

                    @foreach ($clases as $clase)
                        <x-table.tr>
                            <x-table.td justify="center">
                                {{ $clase->actividad->asignaturas[0]->nombre }}
                            </x-table.td>
                            <x-table.td justify="center">
                                {{ $clase->actividad->aulas->pluck('nombre')->implode(', ') }}
                            </x-table.td>
                            <x-table.td justify="center">{{ $clase->actividad->modalidad->nombre }}</x-table.td>
                            <x-table.td justify="center">
                                {{ $clase->tipoClase->nombre . ' ' . ($clase->numero_grupo < 10 ? '0' . $clase->numero_grupo : $clase->numero_grupo) }}
                            </x-table.td>
                            <x-table.td>{{ $clase->actividad->asignaturas[0]->escuela->nombre }}</x-table.td>
                            <x-table.td>
                                {{ \Carbon\Carbon::parse($clase->actividad->hora_inicio)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($clase->actividad->hora_fin)->format('h:i A') }}
                            </x-table.td>
                            <x-table.td>
                                <x-status.is-active :active="$clase->actividad->activo" />
                            </x-table.td>
                            <x-table.td justify="center">
                                <div class="relative flex justify-center space-x-2">
                                    @canany(['CLASES_EDITAR'])
                                    <a
                                        href="#"
                                        class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                        data-id="{{ $clase->id }}"
                                        data-fecha="{{ \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y') }}"
                                        data-materia="{{ $clase->actividad->asignaturas[0]->nombre }}"
                                        data-aulas="{{ $clase->actividad->aulas->pluck('nombre')->implode(', ') }}"
                                        data-hora-inicio="{{ \Carbon\Carbon::parse($clase->actividad->hora_inicio)->format('h:i a') }}"
                                        data-hora-fin="{{ \Carbon\Carbon::parse($clase->actividad->hora_fin)->format('h:i a') }}"
                                        data-tipo-clase="{{ $clase->tipoClase->id }}"
                                        data-modalidad="{{ $clase->actividad->modalidad->id }}"
                                        data-grupo="{{ $clase->numero_grupo }}"
                                        data-dias="{{ $clase->dias_actividad }}"
                                        data-estado="{{ $clase->actividad->activo }}"
                                        data-responsable="{{ $clase->actividad->responsable }}"
                                        data-tooltip-target="tooltip-edit-{{ $clase->id }}"
                                    >
                                        <x-heroicon-s-pencil class="h-5 w-5" />
                                    </a>

                                    <div
                                        id="tooltip-edit-{{ $clase->id }}"
                                        role="tooltip"
                                        class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-green-700 px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                                    >
                                        Editar clase
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    @endcanany

                                    <button
                                        data-modal-target="static-modal-details"
                                        data-modal-toggle="static-modal-details"
                                        class="details-button font-medium text-blue-600 hover:underline dark:text-blue-400"
                                        data-id="{{ $clase->id }}"
                                        data-fecha="{{ \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y') }}"
                                        data-materia="{{ $clase->actividad->asignaturas[0]->nombre }}"
                                        data-aulas="{{ $clase->actividad->aulas->pluck('nombre')->implode(', ') }}"
                                        data-hora-inicio="{{ \Carbon\Carbon::parse($clase->actividad->hora_inicio)->format('h:i a') }}"
                                        data-hora-fin="{{ \Carbon\Carbon::parse($clase->actividad->hora_fin)->format('h:i a') }}"
                                        data-tipo-clase="{{ $clase->tipoClase->id }}"
                                        data-modalidad="{{ $clase->actividad->modalidad->id }}"
                                        data-grupo="{{ $clase->numero_grupo }}"
                                        data-dias="{{ $clase->dias_actividad }}"
                                        data-estado="{{ $clase->actividad->activo }}"
                                        data-responsable="{{ $clase->actividad->responsable }}"
                                        data-tooltip-target="tooltip-view-{{ $clase->id }}"
                                    >
                                        <x-heroicon-s-eye class="h-5 w-5" />
                                    </button>

                                    <div
                                        id="tooltip-view-{{ $clase->id }}"
                                        role="tooltip"
                                        class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-blue-700 px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                                    >
                                        Ver clase
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                    @if ($clase->actividad->activo)
                                        <a
                                            href="{{ route('crear-reporte', ['clase' => $clase->actividad->id]) }}"
                                            class="font-medium text-red-700 hover:underline"
                                            data-tooltip-target="tooltip-report-{{ $clase->id }}"
                                        >
                                            <x-heroicon-s-flag class="mx-2 h-4" />
                                        </a>

                                        <div
                                            id="tooltip-report-{{ $clase->id }}"
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
                {{ $clases->links() }}
            </nav>
        </div>
    </x-container>

    <x-form-modal id="static-modal-details">
        <x-slot name="header">
            <div class="flex items-center space-x-4">
                <x-heroicon-s-book-open class="h-10 w-10 text-escarlata-ues" />
                <div>
                    <h2 id="materia-info" class="text-2xl font-bold text-escarlata-ues"></h2>
                    <h3 class="text-lg font-normal opacity-90">Detalle de la clase</h3>
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
                                <x-heroicon-s-user-group class="h-5 w-5" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Grupo</p>
                                <p id="grupo-info" class="text-[1.1rem] font-semibold uppercase"></p>
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
                                <x-heroicon-s-academic-cap class="h-5 w-5" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Tipo de clase</p>
                                <p id="tipo-clase-info" class="text-[1.1rem] font-semibold uppercase"></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4 p-4">
                            <div class="rounded-full bg-gray-400/20 p-2 text-escarlata-ues">
                                <x-heroicon-s-map-pin class="h-5 w-5" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Local</p>
                                <p id="local-info" class="text-[1.1rem] font-semibold uppercase"></p>
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
                        <div class="flex items-center space-x-4 p-4">
                            <div class="rounded-full bg-gray-400/20 p-2 text-escarlata-ues">
                                <x-heroicon-s-calendar class="h-5 w-5" />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Días</p>
                                <p id="dias-info" class="text-[1.1rem] font-semibold uppercase"></p>
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
            <h3 id="modal-title" class="text-2xl font-bold text-escarlata-ues">Añadir clase</h3>
        </x-slot>
        <x-slot name="body">
            <form id="clase-form" method="POST" action="{{ route('clase.store') }}">
                @csrf
                <x-forms.row :columns="2">
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

                    <div class="space-y-2">
                        <x-forms.select
                            name="tipo"
                            :errors="$errors->get('tipo')"
                            label="Tipo de clase"
                            :options="$tiposClase"
                            :selected="old('tipo')"
                            required
                        />
                        <div id="tipo-clase-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="2">
                    <div class="space-y-2">
                        <x-forms.field
                            label="Número de grupo"
                            type="number"
                            name="grupo"
                            :value="old('grupo')"
                            :error="$errors->get('grupo')"
                            required
                        />
                        <div id="grupo-error" class="text-sm text-red-500"></div>
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
                            required
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
                            required
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
                            label="Local"
                            name="local"
                            pattern="^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ]{1,50}$"
                            patternMessage="Solo se permiten 50 caracteres que sean letras y números"
                            :value="old('local')"
                            :error="$errors->get('local')"
                            required
                        />
                        <div id="local-error" class="text-sm text-red-500"></div>
                    </div>
                    <div class="space-y-2">
                        <div class="space-y-1">
                            <x-forms.input-label for="dias[]" :value="__('Días de actividad')" required />
                            <div class="relative">
                                <button
                                    id="dropdownDiasButton"
                                    data-dropdown-toggle="dropdownDias"
                                    class="w-full rounded-lg border-2 px-4 py-2 text-left text-sm focus:outline-none focus:ring"
                                    type="button"
                                >
                                    Seleccionar dias
                                </button>

                                <!-- Dropdown de dias -->
                                <div
                                    id="dropdownDias"
                                    class="z-20 hidden max-h-[180px] w-full divide-y divide-gray-100 overflow-auto rounded-lg bg-white shadow dark:bg-gray-700"
                                    data-popper-reference-hidden
                                    data-popper-escaped
                                    data-popper-placement="top"
                                >
                                    <ul
                                        class="space-y-2 p-3 text-sm text-gray-700 dark:text-gray-200"
                                        aria-labelledby="dropdownDiasButton"
                                    >
                                        @foreach ($dias as $dia)
                                            <li class="flex items-center">
                                                <input
                                                    id="checkbox-{{ $dia->id }}"
                                                    type="checkbox"
                                                    value="{{ $dia->id }}"
                                                    name="dias[]"
                                                    class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-blue-500"
                                                    onclick="updateSelectedDays()"
                                                />
                                                <label
                                                    for="checkbox-{{ $dia->nombre }}"
                                                    class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                >
                                                    {{ $dia->nombre }}
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <x-forms.input-error :messages="$errors->get('dias')" class="mt-2" />
                        </div>
                        <div id="dia-error" class="text-sm text-red-500"></div>
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
                form="clase-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4"
            >
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>

<script>
    const modalidades = @json($modalidades);
    const tiposClase = @json($tiposClase);

    document.getElementById('clase-form').addEventListener('submit', function (event) {
        const materia = document.getElementById('materia').value.trim();
        const estado = document.getElementById('estado').value;
        const tipo = document.getElementById('tipo').value;
        const hora_inicio = document.getElementById('hora_inicio').value;
        const hora_fin = document.getElementById('hora_fin').value;
        const modalidad = document.getElementById('modalidad').value;
        const local = document.getElementById('local').value.trim();
        const grupo = document.getElementById('grupo').value;
        const dias = document.querySelectorAll('input[name="dias[]"]:checked');
        const responsable = document.getElementById('responsable').value.trim();

        const patternErrors = document.querySelectorAll('div[id*="pattern-error"]');

        const diasArray = [];
        dias.forEach((dia) => diasArray.push(dia.value));

        let hasErrors = false;

        if (!materia) {
            hasErrors = true;
            document.getElementById('materia-error').innerHTML = 'El campo materia es obligatorio';
        } else {
            document.getElementById('materia-error').innerHTML = '';
        }

        if (!tipo) {
            hasErrors = true;
            document.getElementById('tipo-clase-error').innerHTML = 'El campo tipo de clase es obligatorio';
        } else {
            document.getElementById('tipo-clase-error').innerHTML = '';
        }

        if (!hora_inicio) {
            hasErrors = true;
            document.getElementById('hora-inicio-error').innerHTML = 'El campo hora inicio es obligatorio';
        } else {
            document.getElementById('hora-inicio-error').innerHTML = '';
        }

        if (!hora_fin) {
            hasErrors = true;
            document.getElementById('hora-fin-error').innerHTML = 'El campo hora fin es obligatorio';
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
        } else {
            document.getElementById('modalidad-error').innerHTML = '';
        }

        if (!local) {
            hasErrors = true;
            document.getElementById('local-error').innerHTML = 'El campo local es obligatorio';
        } else {
            document.getElementById('local-error').innerHTML = '';
        }

        if (!grupo) {
            hasErrors = true;
            document.getElementById('grupo-error').innerHTML = 'El campo número de grupo es obligatorio';
        } else if (grupo < 1) {
            hasErrors = true;
            document.getElementById('grupo-error').innerHTML = 'El número de grupo debe ser mayor a 0';
        } else {
            document.getElementById('grupo-error').innerHTML = '';
        }

        if (!dias.length && diasArray.length < 1) {
            hasErrors = true;
            document.getElementById('dia-error').innerHTML = 'Debe seleccionar al menos un dia';
        } else {
            document.getElementById('dia-error').innerHTML = '';
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

            document.getElementById('clase-form').action = '{{ route('clase.store') }}';
            document.getElementById('clase-form').method = 'POST';
            let method = document.querySelector('[name="_method"]');
            if (method) document.getElementById('clase-form').removeChild(method);

            document.querySelectorAll('_method').forEach((input) => input.remove());

            document.getElementById('clase-form').reset();
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
            updateSelectedDays();
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function (event) {
            const id = this.getAttribute('data-id');
            const materia = this.getAttribute('data-materia');
            const tipoClase = this.getAttribute('data-tipo-clase');
            const hora_inicio = this.getAttribute('data-hora-inicio');
            const hora_fin = this.getAttribute('data-hora-fin');
            const grupo = this.getAttribute('data-grupo');
            const modalidad = this.getAttribute('data-modalidad');
            const local = this.getAttribute('data-aulas');
            const dias = JSON.parse(this.getAttribute('data-dias'));
            const estado = this.getAttribute('data-estado');
            const responsable = this.getAttribute('data-responsable');

            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));

            updateTitle('Editar clase');

            // Ajustar el formulario para la edición
            document.getElementById('clase-form').action = `{{ route('clase.update', ':id') }}`.replace(':id', id);
            document.getElementById('clase-form').method = 'POST';
            if (!document.querySelector('input[name="_method"]')) {
                document
                    .getElementById('clase-form')
                    .insertAdjacentHTML('beforeend', '<input type="hidden" name="_method" value="PUT">');
            }

            // Asignar los valores al formulario
            document.getElementById('materia').value = materia;
            document.getElementById('tipo').value = tipoClase;
            document.getElementById('hora_inicio').value = hora_inicio;
            document.getElementById('hora_fin').value = hora_fin;
            document.getElementById('modalidad').value = modalidad;
            document.getElementById('grupo').value = grupo;
            document.getElementById('estado').value = estado;
            document.getElementById('responsable').value = responsable;
            document.getElementById('local').value = local;
            if (dias.length > 0) {
                dias.forEach((dia) => {
                    document.getElementById(`checkbox-${dia}`).checked = true;
                });
            }
            updateSelectedDays();

            // Abrir el modal
            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });

    document.querySelectorAll('.details-button').forEach((button) => {
        button.addEventListener('click', function (event) {
            const materia = this.getAttribute('data-materia');
            const tipoClase = this.getAttribute('data-tipo-clase');
            const hora_inicio = this.getAttribute('data-hora-inicio');
            const hora_fin = this.getAttribute('data-hora-fin');
            const grupo = this.getAttribute('data-grupo');
            const modalidad = this.getAttribute('data-modalidad');
            const local = this.getAttribute('data-aulas');
            const dias = JSON.parse(this.getAttribute('data-dias'));
            const estado = this.getAttribute('data-estado');
            const responsable = this.getAttribute('data-responsable');

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

            document.getElementById('tipo-clase-info').textContent = tiposClase[tipoClase];
            document.getElementById('horario-info').textContent =
                convertirHora12H(hora_inicio) + ' - ' + convertirHora12H(hora_fin);
            document.getElementById('grupo-info').textContent = 'Grupo ' + grupo;
            document.getElementById('responsable-info').textContent = responsable;
            document.getElementById('local-info').textContent = local;
            document.getElementById('dias-info').textContent = dias.map((dia) => numeroADia(dia)).join(', ');
        });
    });

    function updateTitle(title) {
        document.getElementById('modal-title').textContent = title;
    }

    function numeroADia(numero) {
        const dias = {
            0: 'Domingo',
            1: 'Lunes',
            2: 'Martes',
            3: 'Miércoles',
            4: 'Jueves',
            5: 'Viernes',
            6: 'Sábado',
        };
        return dias[numero] || 'Número inválido';
    }

    function convertirHora12H(hora) {
        let [horas, minutos] = hora.split(':').map(Number);
        let periodo = horas >= 12 ? 'PM' : 'AM';

        // Convertir a formato de 12 horas
        horas = horas % 12 || 12;

        return `${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')} ${periodo}`;
    }
</script>

<script>
    function updateSelectedDays() {
        const checkboxes = document.querySelectorAll(`#dropdownDias input[type="checkbox"]`);
        const selected = [];

        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                selected.push(checkbox.nextElementSibling.textContent.trim());
            }
        });

        const button = document.getElementById('dropdownDiasButton');
        button.textContent = selected.length ? selected.join(', ') : 'Seleccionar dias';
    }
</script>
