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

    $cicloActivo = \App\Models\Mantenimientos\Ciclo::with('tipoCiclo')->where('activo', 1)->first();
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
                    @if(isset($cicloActivo))
                        <x-forms.primary-button data-modal-target="static-modal" data-modal-toggle="static-modal"
                            type="button">
                            Añadir
                        </x-forms.primary-button>
                    @endif
                </div>
            </x-slot>
        </x-header.main>
    </x-slot>

    <x-container>
        {{-- FILTROS --}}
        <div class="flex-column flex flex-wrap items-center gap-3 space-y-4 pb-4 sm:flex-row sm:space-y-0">
            <div class="flex-col flex flex-wrap items-center justify-between space-y-4 pb-4 sm:flex-row sm:space-y-0 w-full">
                <form action="{{ route('listado-clases') }}" method="GET" class="flex-row flex flex-wrap items-center space-x-8 mt-4 w-full">
                    <div class="flex w-full flex-col md:w-5/6 px-4 md:px-0">
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
                    <div class="flex flex-wrap space-x-4">
                        <button type="submit"
                                class="align-middle rounded-full inline-flex items-center px-3 py-3 border border-transparent shadow-sm text-sm font-medium text-white bg-escarlata-ues hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                            </svg>
                        </button>

                        <button type="reset"
                                class="align-middle rounded-full inline-flex items-center px-3 py-3 shadow-sm text-sm font-medium bg-white border border-gray-500 text-gray-500 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                                onclick="window.location.href='{{ route('listado-clases') }}';">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="h-4 w-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
            {{-- TABLA --}}
            <div class="mx-auto mb-6 flex flex-col overflow-x-auto sm:rounded-lg">
                <x-table.base :headers="$headers" id="table-content">
                    @if($clases->isEmpty())
                        <x-table.td colspan="{{ count($headers) }}" justify="center">
                            <span class="text-gray-500">No se encontraron registros</span>
                        </x-table.td>
                    @endif
                    @foreach ($clases as $clase)
                        <x-table.tr>
                            <x-table.td justify="center">{{ $clase->actividad->asignaturas[0]->nombre }}</x-table.td>
                            <x-table.td justify="center">{{ $clase->actividad->aulas->pluck('nombre')->implode(', ') }}</x-table.td>
                            <x-table.td justify="center">{{ $clase->actividad->modalidad->nombre }}</x-table.td>
                            <x-table.td justify="center">{{ $clase->tipoClase->nombre . ' ' . ($clase->numero_grupo < 10 ? '0'. $clase->numero_grupo : $clase->numero_grupo) }}</x-table.td>
                            <x-table.td>{{ $clase->actividad->asignaturas[0]->escuela->nombre }}</x-table.td>
                            <x-table.td>{{ \Carbon\Carbon::parse($clase->actividad->hora_inicio)->format('H:i'). ' - '. \Carbon\Carbon::parse($clase->actividad->hora_fin)->format('H:i') }}</x-table.td>
                            <x-table.td>
                                <x-status.is-active :active="$clase->actividad->activo" />
                            </x-table.td>
                            <x-table.td>
                                <div class="flex space-x-2 justify-center">
                                    <a href="#"
                                        class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                        data-id="{{ $clase->id }}" data-fecha="{{ \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y') }}"
                                        data-materia="{{ $clase->actividad->asignaturas[0]->nombre }}" data-aulas="{{ $clase->actividad->aulas->pluck('nombre')->implode(', ') }}"
                                        data-hora-inicio="{{ \Carbon\Carbon::parse($clase->actividad->hora_inicio)->format('H:i') }}" data-hora-fin="{{ \Carbon\Carbon::parse($clase->actividad->hora_fin)->format('H:i') }}"
                                        data-tipo-clase="{{ $clase->tipoClase->id }}" data-modalidad="{{ $clase->actividad->modalidad->id }}"
                                        data-grupo="{{ $clase->numero_grupo }}" data-dias="{{ $clase->dias_actividad }}"
                                        data-estado="{{ $clase->actividad->activo }}" data-responsable="{{ $clase->actividad->responsable }}"
                                    >
                                    <x-heroicon-o-pencil class="h-5 w-5" />
                                    </a>
                                    @if($clase->actividad->activo)
                                        <a href="{{ route('crear-reporte', ['actividad' => $clase->actividad->id]) }}" class="font-medium text-gray-700 hover:underline">
                                            <x-heroicon-s-flag class="mx-2 h-4" />
                                        </a>
                                    @endif
                                </div>
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </x-table.base>
            </div>
            <nav
                class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row w-full"
                aria-label="Table navigation"
            >
                {{ $clases->links() }}
            </nav>
        </div>
    </x-container>

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
                        <x-forms.field label="Materia" name="materia" type="text" :value="old('materia')" :error="$errors->get('materia')" required />
                        <div id="materia-error" class="text-sm text-red-500"></div>
                    </div>

                    <div class="space-y-2">
                        <x-forms.select name="tipo" :errors="$errors->get('tipo')" label="Tipo de clase" :options="$tiposClase" :selected="old('tipo')" required />
                        <div id="tipo-clase-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="2">
                    <div class="space-y-2">
                        <x-forms.field label="Número de grupo" type="number" name="grupo" :value="old('grupo')" :error="$errors->get('grupo')" required />
                        <div id="grupo-error" class="text-sm text-red-500"></div>
                    </div>

                    {{-- Hora Fin --}}
                    <div class="space-y-2">
                        <x-forms.select name="modalidad" :errors="$errors->get('modalidad')" label="Modalidad" :options="$modalidades" :selected="old('modalidad')" required />
                        <div id="modalidad-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="2">
                    <div class="space-y-2">
                        <x-forms.field label="Hora inicio" name="hora_inicio"  type="time" :value="old('hora_inicio')" :error="$errors->get('hora_inicio')" />
                        <div id="hora-inicio-error" class="text-sm text-red-500"></div>
                    </div>

                    {{-- Hora Fin --}}
                    <div class="space-y-2">
                        <x-forms.field label="Hora fin" name="hora_fin"  type="time" :value="old('hora_fin')" :error="$errors->get('hora_fin')"  />
                        <div id="hora-fin-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="2">
                    <div class="space-y-2">
                        <x-forms.field label="Responsable" name="responsable" :value="old('responsable')" :error="$errors->get('responsable')" required />
                        <div id="responsable-error" class="text-sm text-red-500"></div>
                    </div>

                    {{-- Hora Fin --}}
                    <div class="space-y-2">
                        <x-forms.select name="estado" :errors="$errors->get('estado')" label="Estado" :options="[1 => 'ACTIVO', 0 => 'INACTIVO']"  :selected="old('estado', 1)" required />
                        <div id="estado-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="2">
                    <div class="space-y-2">
                        <x-forms.field label="Local" name="local"  :value="old('local')" :error="$errors->get('local')" required />
                        <div id="local-error" class="text-sm text-red-500"></div>
                    </div>
                    <div class="space-y-2">
                        <div class="space-y-1">
                            <x-forms.input-label for="dias[]" :value="__('Días de actividad')" />
                            <div class="relative">
                                <button
                                    id="dropdownDiasButton"
                                    data-dropdown-toggle="dropdownDias"
                                    class="w-full px-4 py-2 border-2 rounded-lg text-left focus:outline-none focus:ring text-sm"
                                    type="button">
                                    Seleccionar dias
                                </button>

                                <!-- Dropdown de dias -->
                                <div
                                    id="dropdownDias"
                                    class="hidden z-20 w-full max-h-[180px] overflow-auto bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700"
                                    data-popper-reference-hidden
                                    data-popper-escaped
                                    data-popper-placement="top">
                                    <ul class="p-3 space-y-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDiasButton">
                                        @foreach($dias as $dia)
                                            <li class="flex items-center">
                                                <input
                                                    id="checkbox-{{ $dia->id }}"
                                                    type="checkbox"
                                                    value="{{ $dia->id }}"
                                                    name="dias[]"
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                                    onclick="updateSelectedDays()">
                                                <label for="checkbox-{{ $dia->nombre }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
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
            <button data-modal-hide="static-modal" type="button"
                class="rounded-lg border bg-gray-700 px-7 py-2.5 text-sm font-medium text-white focus:z-10 focus:outline-none focus:ring-4">
                Cancelar
            </button>
            <button type="submit" form="clase-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>

<script>
    document.getElementById('clase-form').addEventListener('submit', function(event) {
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

        if(hora_inicio && hora_fin) {
            const inicio = new Date(`01/01/2000 ${hora_inicio}`);
            const fin = new Date(`01/01/2000 ${hora_fin}`);

            if(inicio >= fin) {
                hasErrors = true;
                document.getElementById('hora-inicio-error').innerHTML = 'La hora de inicio debe ser menor a la hora de fin';
                document.getElementById('hora-fin-error').innerHTML = 'La hora de fin debe ser mayor a la hora de inicio';
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
    });

    document.querySelectorAll('[data-modal-hide="static-modal"]').forEach((button) => {
        button.addEventListener('click', function() {
            updateTitle('Añadir evento o evaluación');

            document.getElementById('clase-form').action = '{{ route('clase.store') }}';
            document.getElementById('clase-form').method = 'POST';
            let method = document.querySelector('[name="_method"]')
            if(method) document.getElementById('clase-form').removeChild(method);

            document.querySelectorAll('_method').forEach((input) => input.remove());

            document.getElementById('clase-form').reset();
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
            updateSelectedDays();
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function(event) {
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
                document.getElementById('clase-form').insertAdjacentHTML('beforeend', '<input type="hidden" name="_method" value="PUT">');
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
            if(dias.length > 0) {
                dias.forEach((dia) => {
                    document.getElementById(`checkbox-${dia}`).checked = true;
                });
            }
            updateSelectedDays();

            // Abrir el modal
            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });
    function updateTitle(title) {
        document.getElementById('modal-title').textContent = title;
    }
</script>

<script>
    function updateSelectedDays() {
        const checkboxes = document.querySelectorAll(`#dropdownDias input[type="checkbox"]`);
        const selected = [];

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selected.push(checkbox.nextElementSibling.textContent.trim());
            }
        });

        const button = document.getElementById('dropdownDiasButton');
        button.textContent = selected.length ? selected.join(', ') : 'Seleccionar dias';
    }
</script>
