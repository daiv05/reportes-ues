@php
    // Si se presiona el botón "Limpiar datos", olvidar la sesión.
    if (request()->has('clear_session')) {
        session()->forget('excelData');
    }
@endphp
<x-app-layout>
    <x-slot name="header">
        <x-header.main
            tituloMenor="Importación de"
            tituloMayor="Actividades"
            subtitulo="Crea actividades que se llevaran a cabo en el ciclo a tráves de una hoja de cálculo"
        />
    </x-slot>

    <x-container>
        <div class="max-w-7xl mx-auto sm:px-1 lg:px-3">
            @php
                $cicloActivo = \App\Models\Mantenimientos\Ciclo::with('tipoCiclo')->where('activo', 1)->first();
                $dias = \App\Models\General\Dia::all();
                $aulas = \App\Models\Mantenimientos\Aulas::all();
            @endphp
            @if(isset($cicloActivo))
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6">
                <h1 class="text-xl font-bold text-orange-900 mb-2">
                    Ciclo activo: {{ $cicloActivo->anio . '-' . $cicloActivo->tipoCiclo->nombre }}
                </h1>
                <div class="grid grid-cols-1">
                    <div class="col-span-1">
                        <h2 class="text-lg font-semibold text-gray-700">Instrucciones</h2>
                        <p class="text-sm text-gray-600">
                            Utiliza la plantilla de actividades, llena la información y sube el archivo.
                        </p>
                    </div>
                    <div class="col-span-1">
                        <form id="import-excel" action="{{ route('importar-actividades-post') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @csrf
                            <div class="mt-4">
                                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de actividad</label>
                                <select id="tipo_actividad" name="tipo_actividad" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="evento">Evento</option>
                                    <option value="clase">Clase</option>
                                </select>
                            </div>
                            <div class="flex items-center justify-center w-full">
                                <label for="file" class="w-64 flex flex-col items-center px-4 py-6 bg-white text-orange-900 rounded-lg shadow-lg tracking-wide uppercase border border-orange-900 cursor-pointer hover:bg-orange-900 hover:text-white">
                                    <x-heroicon-o-cloud-arrow-up class="w-10 h-10" />
                                    <span id="file-name" class="mt-2 text-base leading-normal">Selecciona un archivo</span>
                                    <input type="file" name="excel_file" accept=".xls,.xlsx,.csv" id="file" class="hidden" onchange="updateFileName(this)" />
                                    @if ($errors->has('excel_file'))
                                        <span class="text-red-500 text-sm text-center">{{ $errors->first('excel_file') }}</span>
                                    @endif
                                </label>
                            </div>
                            <div class="flex items-center py-2 gap-2 md:gap-4 justify-center w-full mt-4 md:col-span-2">
                                <x-forms.primary-button>
                                    Subir archivo
                                </x-forms.primary-button>
                            </div>
                        </form>

                        {{-- Formulario para limpiar sesión --}}
                        @if(session()->has('excelData'))
                            <form id="forget-session-form" action="{{ route('importar-actividades') }}" method="GET" class="mt-4 flex justify-center">
                                @csrf
                                <input type="hidden" name="clear_session" value="true">
                                <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150">
                                    Limpiar datos
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            @else
                <div class="flex items-center justify-center min-h-[20rem] bg-gray-100">
                    <div class="max-w-sm w-full bg-white shadow-lg rounded-lg overflow-hidden">
                        <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-escarlata-ues" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            </div>
                            <div class="ml-3 w-0 flex-1">
                            <h3 class="text-lg font-medium text-escarlata-ues">
                                No hay ciclo activo
                            </h3>
                            <div class="mt-2 text-sm text-gray-500">
                                <p>
                                Actualmente no hay ningún ciclo en curso. Por favor, inicia un nuevo ciclo para comenzar.
                                </p>
                            </div>
                            </div>
                        </div>
                        </div>
                        <div class="flex justify-center bg-gray-50 px-4 py-4 sm:px-6">
                            <a href={{ route('ciclos.index') }} class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-orange-900 bg-orange-100 hover:bg-orange-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-900">
                                Iniciar nuevo ciclo
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Vista previa de la información --}}
            @if((session()->has('excelData') || isset($excelData)) && $cicloActivo)
                @php
                    $excelData = session('excelData', $excelData ?? []);
                    $tipoActividad = session('tipoActividad');
                    $tipoClases = \App\Models\General\TipoClase::all();
                    $modalidades = \App\Models\General\Modalidad::all();
                @endphp

                <h1 class="text-xl font-bold text-orange-900 mt-5 mb-3">Vista previa de la información</h1>

                @if($tipoActividad == 'evento')

                    {{-- Caso para eventos --}}
                    <form class="p-5" method="POST" action="{{ route('importar-eventos') }}">
                        @csrf
                        <div class="flex items-center justify-center w-full mt-4 md:col-span-2">
                            <button type="submit" class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                                Guardar eventos
                            </button>
                        </div>

                        <div id="ebento-records-container">
                            @foreach($excelData as $row)
                                <div class="record-block shadow-sm p-5 rounded-lg border-b border-gray-300 mb-5" data-index="{{ $loop->index }}">
                                    <div class="flex flex-wrap gap-3 md:gap-8 items-center my-4">
                                        <h1 class="text-xl font-bold text-orange-900 mt-5 mb-3">Registro de actividad {{ $loop->iteration }} - Semana {{ $row['semana'] }}</h1>
                                        {{-- Botón para eliminar --}}
                                        <button type="button" onclick="deleteRecord({{ $loop->index }})"
                                                class="flex gap-2 text-sm h-fit text-gray-500 hover:text-red-500 hover:bg-red-100 p-3 rounded-full transition-colors duration-200 border-2 hover:border-red-100 border-gray-300">
                                            <x-heroicon-o-trash class="h-[20px]" />
                                            Eliminar registro
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">

                                        {{-- Fecha --}}
                                        <div class="space-y-1">
                                            <x-forms.input-label for="fecha[]" :value="__('Fecha')" required />
                                            <x-forms.date-input
                                                type="date"
                                                name="fecha[]"
                                                :value="old('fecha.' . $loop->index, $row['fecha'])"
                                                required
                                                class="w-full mt-1"
                                            />
                                            <x-forms.input-error :messages="$errors->get('fecha.'. $loop->index)" class="mt-2" />
                                        </div>

                                        {{-- Materia --}}
                                        <x-forms.field
                                            label="Materia"
                                            name="materia[]"
                                            :value="old('materia.' . $loop->index, $row['materia'])"
                                            :error="$errors->get('materia.' . $loop->index)"
                                            required
                                        />

                                        {{-- Hora Inicio --}}
                                        <x-forms.field
                                            label="Hora Inicio"
                                            type="time"
                                            name="hora_inicio[]"
                                            :value="old('hora_inicio.' . $loop->index, $row['hora_inicio'])"
                                            :error="$errors->get('hora_inicio.' . $loop->index)"
                                            required
                                        />


                                        {{-- Hora Fin --}}
                                        <x-forms.field
                                            label="Hora Fin"
                                            type="time"
                                            name="hora_fin[]"
                                            :value="old('hora_fin.' . $loop->index, $row['hora_fin'])"
                                            :error="$errors->get('hora_fin.' . $loop->index)"
                                            required
                                        />

                                        {{-- Evaluación --}}
                                        <x-forms.field
                                            label="Evaluación"
                                            name="evaluacion[]"
                                            :value="old('evaluacion.' . $loop->index, $row['evaluacion'])"
                                            :error="$errors->get('evaluacion.' . $loop->index)"
                                            required
                                        />

                                        {{-- Cantidad de estudiantes --}}
                                        <x-forms.field
                                            label="Cantidad de estudiantes"
                                            type="number"
                                            name="cantidad_estudiantes[]"
                                            :value="old('cantidad_estudiantes.' . $loop->index, $row['cantidad_estudiantes'])"
                                            :error="$errors->get('cantidad_estudiantes.' . $loop->index)"
                                            required
                                        />

                                        {{-- Modalidad --}}
                                        <x-forms.select
                                            label="Modalidad"
                                            name="modalidad[]"
                                            :options="$modalidades->pluck('nombre', 'id')"
                                            :selected="old('modalidad.' . $loop->index, $row['modalidad'])"
                                            :error="$errors->get('modalidad.' . $loop->index)"
                                            required
                                        />

                                        {{-- Selección de locales --}}
                                        <div class="space-y-1">
                                            <x-forms.input-label for="aulas[]" :value="__('Locales')" />
                                            <div class="relative">
                                                <button
                                                    id="dropdownAulasButton{{ $loop->iteration }}"
                                                    data-dropdown-toggle="dropdownAulas{{ $loop->iteration }}"
                                                    class="text-left w-full rounded-md border border-gray-300 py-2 px-3 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 text-sm"
                                                    type="button">
                                                    Seleccionar aulas
                                                </button>

                                                <!-- Dropdown de aulas -->
                                                <div
                                                    id="dropdownAulas{{ $loop->iteration }}"
                                                    class="hidden z-20 w-full max-h-[180px] overflow-auto bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700"
                                                    data-popper-reference-hidden
                                                    data-popper-escaped
                                                    data-popper-placement="top">
                                                    <ul class="p-3 space-y-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownAulasButton{{ $loop->iteration }}">
                                                        @foreach($aulas as $aula)
                                                            <li class="flex items-center">
                                                                <input
                                                                    id="checkbox-{{ $aula->nombre }}-{{ $loop->parent->iteration }}"
                                                                    type="checkbox"
                                                                    value="{{ $aula->id }}"
                                                                    name="aulas[{{ $loop->parent->index }}][]"
                                                                    @if(is_array(old('aulas.' . $loop->parent->index, $row['aulas'])) && in_array($aula->id, old('aulas.' . $loop->parent->index, $row['aulas'])))
                                                                        checked
                                                                    @endif
                                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                                                    onclick="updateSelectedAulas({{ $loop->parent->iteration }})">
                                                                <label for="checkbox-{{ $aula->nombre }}-{{ $loop->parent->iteration }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                                    {{ $aula->nombre }}
                                                                </label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <x-forms.input-error :messages="$errors->get('aulas.' . $loop->index)" class="mt-2" />
                                        </div>

                                        {{-- Responsable --}}
                                        <div class="col-span-1 sm:col-span-2 md:col-span-4">
                                            <x-forms.field
                                                label="Responsable"
                                                name="responsable[]"
                                                :value="old('responsable.' . $loop->index)"
                                                :error="$errors->get('responsable.' . $loop->index)"
                                            />
                                        </div>

                                        {{-- Comentarios--}}
                                        <div class="col-span-1 sm:col-span-2 md:col-span-4">
                                            <x-forms.input-label for="comentarios[]" :value="__('Comentarios')" />
                                            <textarea
                                                id="comentario[]"
                                                name="comentarios[]"
                                                rows="2"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                            >{{ old('comentarios.' . $loop->index, $row['comentarios']) }}</textarea>
                                            <x-forms.input-error :messages="$errors->get('comentarios.' . $loop->index)" />
                                        </div>


                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </form>
                @endif

                @if($tipoActividad == 'clase')

                    {{-- Caso para clases --}}
                    <form class="p-5" method="POST" action="{{ route('importar-clases') }}">
                        @csrf
                        @method('POST')
                        <div class="flex items-center justify-center w-full mt-4 md:col-span-2">
                            <button type="submit" class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                                Guardar clases
                            </button>
                        </div>

                        <div id="clase-records-container">
                            @foreach($excelData as $row)
                                <div class="record-block shadow-sm p-5 rounded-lg border-b border-gray-300 mb-5" data-index="{{ $loop->index }}">
                                    <div class="flex flex-wrap gap-3 md:gap-8 items-center my-4">
                                        <h1 class="text-xl font-bold text-orange-900">Registro de actividad {{ $loop->iteration }}</h1>
                                        {{-- Botón para eliminar --}}
                                        <button type="button" onclick="deleteRecord({{ $loop->index }})"
                                                class="flex gap-2 text-sm h-fit text-gray-500 hover:text-red-500 hover:bg-red-100 p-3 rounded-full transition-colors duration-200 border-2 hover:border-red-100 border-gray-300">
                                            <x-heroicon-o-trash class="h-[20px]" />
                                            Eliminar registro
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">

                                        {{-- Materia --}}
                                        <x-forms.field
                                            label="Materia"
                                            name="materia[]"
                                            :value="old('materia.' . $loop->index, $row['materia'])"
                                            :error="$errors->get('materia.' . $loop->index)"
                                            required
                                        />

                                        {{-- Tipo de clase --}}
                                        <x-forms.select
                                            label="Tipo de clase"
                                            name="tipo[]"
                                            :options="$tipoClases->pluck('nombre', 'id')"
                                            :selected="old('tipo.' . $loop->index, $row['tipo'])"
                                            :error="$errors->get('tipo.' . $loop->index)"
                                            required
                                        />

                                        {{-- Modalidad --}}
                                        <x-forms.select
                                            label="Modalidad"
                                            name="modalidad[]"
                                            :options="$modalidades->pluck('nombre', 'id')"
                                            :selected="old('modalidad.' . $loop->index, $row['modalidad'])"
                                            :error="$errors->get('modalidad.' . $loop->index)"
                                            required
                                        />

                                        {{-- Numero de grupo --}}
                                        <x-forms.field
                                            label="Número de grupo"
                                            type="number"
                                            name="grupo[]"
                                            :value="old('grupo.' . $loop->index, $row['grupo'])"
                                            :error="$errors->get('grupo.' . $loop->index)"
                                            required
                                        />

                                        {{-- Hora Inicio --}}
                                        <x-forms.field
                                            label="Hora Inicio"
                                            type="time"
                                            name="hora_inicio[]"
                                            :value="old('hora_inicio.' . $loop->index, $row['hora_inicio'])"
                                            :error="$errors->get('hora_inicio.' . $loop->index)"
                                            required
                                        />


                                        {{-- Hora Fin --}}
                                        <x-forms.field
                                            label="Hora Fin"
                                            type="time"
                                            name="hora_fin[]"
                                            :value="old('hora_fin.' . $loop->index, $row['hora_fin'])"
                                            :error="$errors->get('hora_fin.' . $loop->index)"
                                            required
                                        />

                                        {{-- Local --}}
                                        <x-forms.field
                                            label="Local"
                                            name="local[]"
                                            :value="old('local.' . $loop->index, $row['local'])"
                                            :error="$errors->get('local.' . $loop->index)"
                                            required
                                        />

                                        {{-- Selección de días --}}
                                        <div class="space-y-1">
                                            <x-forms.input-label for="diasActividad[]" :value="__('Días de actividad')" required />
                                            <div class="relative">
                                                <button
                                                    id="dropdownDaysButton{{ $loop->iteration }}"
                                                    data-dropdown-toggle="dropdownDays{{ $loop->iteration }}"
                                                    class="text-left w-full rounded-md border border-gray-300 py-2 px-3 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 text-sm"
                                                    type="button">
                                                    Seleccionar días
                                                </button>

                                                <!-- Dropdown de días -->
                                                <div
                                                    id="dropdownDays{{ $loop->iteration }}"
                                                    class="hidden z-20 w-full max-h-[180px] overflow-auto bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700"
                                                    data-popper-reference-hidden
                                                    data-popper-escaped
                                                    data-popper-placement="top">
                                                    <ul class="p-3 space-y-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDaysButton{{ $loop->iteration }}">
                                                        @foreach($dias as $dia)
                                                            <li class="flex items-center">
                                                                <input
                                                                    id="checkbox-{{ $dia->nombre }}-{{ $loop->parent->iteration }}"
                                                                    type="checkbox"
                                                                    value="{{ $dia->id }}"
                                                                    name="diasActividad[{{ $loop->parent->index }}][]"
                                                                    @if(is_array(old('diasActividad.' . $loop->parent->index, $row['diasActividad'])) && in_array($dia->id, old('diasActividad.' . $loop->parent->index, $row['diasActividad'])))
                                                                        checked
                                                                    @endif
                                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                                                    onclick="updateSelectedDays({{ $loop->parent->iteration }})">
                                                                <label for="checkbox-{{ $dia->nombre }}-{{ $loop->parent->iteration }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                                    {{ $dia->nombre }}
                                                                </label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                            <x-forms.input-error :messages="$errors->get('diasActividad.' . $loop->index)" class="mt-2" />
                                        </div>

                                        {{-- Responsable --}}
                                        <div class="col-span-1 sm:col-span-2 md:col-span-4">
                                            <x-forms.field
                                                label="Responsable"
                                                name="responsable[]"
                                                :value="old('responsable.' . $loop->index)"
                                                :error="$errors->get('responsable.' . $loop->index)"
                                            />
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                @endif
            @endif
        </div>
    </x-container>
</x-app-layout>

<script>
    function updateFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : "Selecciona un archivo";
        document.getElementById('file-name').textContent = fileName;
    }

    function updateSelectedDays(index) {
        const checkboxes = document.querySelectorAll(`#dropdownDays${index} input[type="checkbox"]`);
        const selected = [];

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selected.push(checkbox.nextElementSibling.textContent.trim());
            }
        });

        const button = document.getElementById(`dropdownDaysButton${index}`);
        button.textContent = selected.length ? selected.join(', ') : 'Seleccionar días';
    }

    function updateSelectedAulas(index) {
        const checkboxes = document.querySelectorAll(`#dropdownAulas${index} input[type="checkbox"]`);
        const selected = [];

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selected.push(checkbox.nextElementSibling.textContent.trim());
            }
        });

        const button = document.getElementById(`dropdownAulasButton${index}`);
        button.textContent = selected.length ? selected.join(', ') : 'Seleccionar locales';
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Initialize the button text with the initially selected values
        @foreach ($dias as $index => $actividad)
            updateSelectedDays({{ $loop->iteration }});
        @endforeach

    });

    document.addEventListener('DOMContentLoaded', () => {
        // Initialize the button text with the initially selected values
        @foreach ($aulas as $index => $aula)
            updateSelectedAulas({{ $loop->iteration }});
        @endforeach
    });

    function deleteRecord(index) {
        // enviar formulario para eliminar
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('eliminar-evento-sesion', '') }}' + '/' + index;
        form.style.display = 'none';
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }


</script>
