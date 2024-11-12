<x-app-layout>
    <x-slot name="header">
        <x-header.main
            tituloMenor="Importación de"
            tituloMayor="Actividades"
            subtitulo="Crea actividades que se llevaran a cabo en el ciclo a tráves de una hoja de cálculo"
        />
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto sm:px-1 lg:px-3">
            @php
                $cicloActivo = \App\Models\Mantenimientos\Ciclo::with('tipoCiclo')->where('activo', 1)->first();
            @endphp
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6">
                @if(isset($cicloActivo))
                    <h1 class="text-xl font-bold text-orange-900 mb-2">Ciclo activo: {{ $cicloActivo->anio.'-'. $cicloActivo->tipoCiclo->nombre }}</h1>
                    <div class="grid grid-cols-1">
                        <div class="col-span-1">
                            <h2 class="text-lg font-semibold text-gray-700">Instrucciones</h2>
                            <p class="text-sm text-gray-600">Utiliza la plantilla de actividades, llena la información y sube el archivo.</p>
                        </div>
                        <div class="col-span-1">
                            <form action="{{ route('importar-actividades-post') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @csrf
                                <div class="mt-4">
                                    <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de actividad</label>
                                    <select id="tipo_actividad" name="tipo_actividad" class="mt-1 block
                                        w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="evento">Evento</option>
                                        <option value="clase">Clase</option>
                                    </select>
                                </div>
                                <div class="flex items-center justify-center w-full">
                                    <label for="file" class="w-64 flex flex-col items-center px-4 py-6 bg-white text-orange-900 rounded-lg shadow-lg tracking-wide uppercase border border-orange-900 cursor-pointer hover:bg-orange-900 hover:text-white">
                                        <x-heroicon-o-cloud-arrow-up class="w-10 h-10" />
                                        <span id="file-name" class="mt-2 text-base leading-normal">
                                            Selecciona un archivo
                                        </span>
                                        <input type="file" name="excel_file" id="file" class="hidden" onchange="updateFileName(this)" />
                                        @if ($errors->has('excel_file'))
                                            <span class="text-red-500 text-sm text-center">{{ $errors->first('excel_file') }}</span>
                                        @endif
                                    </label>
                                </div>
                                <div class="flex items-center justify-center w-full mt-4 md:col-span-2">
                                    <button type="submit" class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                                        Subir archivo
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <h1 class="text-xl font-bold text-orange-900">No hay un ciclo activo</h1>
                @endif
            </div>

            @if(session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mt-5" role="alert">
                    <strong class="font-bold">¡Éxito!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session()->has('excelData') || isset($excelData))
                @php
                    $excelData = session('excelData', $excelData ?? []);
                    $tipoActividad = session('tipoActividad');
                    $tipoClases = \App\Models\General\TipoClase::all();
                    $modalidades = \App\Models\General\Modalidad::all();
                    $dias = \App\Models\General\Dia::all();
                    $cicloActivo = \App\Models\General\Ciclo::where('activo', 1)->first();
                @endphp

                <h1 class="text-xl font-bold text-orange-900 mt-5 mb-3">Vista previa de la información</h1>

                {{-- Caso para eventos --}}
                @if($tipoActividad == 'evento')
                    <form class="p-5" method="POST" action="{{ route('importar-eventos') }}">
                        @csrf
                        <div class="flex items-center justify-center w-full mt-4 md:col-span-2">
                            <button type="submit" class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                                Guardar eventos
                            </button>
                        </div>

                        @foreach($excelData as $row)
                            <h1 class="text-xl font-bold text-orange-900 mt-5 mb-3">Registro de actividad {{ $loop->iteration }} - Semana {{ $row['semana'] }}</h1>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">

                                {{-- Fecha --}}
                                <div class="space-y-2">
                                    <x-forms.input-label for="fecha[]" :value="__('Fecha')" />
                                    <x-forms.date-input
                                        type="date"
                                        name="fecha[]"
                                        :value="old('fecha.' . $loop->index, $row['fecha'])"
                                        required
                                        class="w-full mt-1"
                                    />
                                    <x-forms.input-error :messages="$errors->get('fecha'. $loop->index)" class="mt-2" />
                                </div>

                                {{-- Materia --}}
                                <div class="space-y-1">
                                    <x-forms.input-label for="materia[]" :value="__('Materia')" />
                                    <x-forms.text-input
                                        name="materia[]"
                                        :value="old('materia.' . $loop->index, $row['materia'])"
                                        class="w-full mt-1"
                                    />
                                    <x-forms.input-error :messages="$errors->get('materia.' . $loop->index)"/>
                                </div>

                                {{-- Hora Inicio --}}
                                <div class="space-y-2">
                                    <x-forms.input-label for="hora_inicio[]" :value="__('Hora Inicio')" />
                                    <x-forms.text-input
                                        type="time"
                                        name="hora_inicio[]"
                                        :value="old('hora_inicio.' . $loop->index, $row['hora_inicio'])"
                                        class="w-full mt-1"
                                    />
                                    <x-forms.input-error :messages="$errors->get('hora_inicio')" class="mt-2" />
                                </div>

                                {{-- Hora Fin --}}
                                <div class="space-y-2">
                                    <x-forms.input-label for="hora_fin[]" :value="__('Hora Fin')" />
                                    <x-forms.text-input
                                        type="time"
                                        name="hora_fin[]"
                                        :value="$row['hora_fin']"
                                        class="w-full mt-1"
                                    />
                                    <x-forms.input-error :messages="$errors->get('hora_fin')" class="mt-2" />
                                </div>

                                {{-- Evaluación --}}
                                <div class="space-y-1">
                                    <x-forms.input-label for="evaluacion[]" :value="__('Evaluación')" />
                                    <x-forms.text-input
                                        name="evaluacion[]"
                                        :value="old('evaluacion.' . $loop->index, $row['evaluacion'])"
                                        class="w-full mt-1"
                                    />
                                    <x-forms.input-error :messages="$errors->get('evaluacion.' . $loop->index)"/>
                                </div>

                                {{-- Cantidad de estudiantes --}}
                                <div class="space-y-1">
                                    <x-forms.input-label for="cantidad_estudiantes[]" :value="__('Cantidad de estudiantes')" />
                                    <x-forms.text-input
                                        type="number"
                                        name="cantidad_estudiantes[]"
                                        :value="old('cantidad_estudiantes.' . $loop->index, $row['cantidad_estudiantes'])"
                                        class="w-full mt-1"
                                    />
                                    <x-forms.input-error :messages="$errors->get('cantidad_estudiantes.' . $loop->index)"/>
                                </div>

                                {{-- Modalidad --}}
                                <div class="space-y-2">
                                    <x-forms.input-label for="modalidad[]" :value="__('Modalidad')" />
                                    <select id="modalidad" name="modalidad[]" class="mt-1 w-full pl-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        @foreach($modalidades as $modalidad)
                                            <option value="{{ $modalidad->id }}" {{ $modalidad->id == $row['modalidad'] ? 'selected' : '' }}>
                                                {{ $modalidad->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-forms.input-error :messages="$errors->get('modalidad')" class="mt-2" />
                                </div>

                                {{-- Locales --}}
                                <div class="space-y-1">
                                    <x-forms.input-label for="local[]" :value="__('Locales')" />
                                    <x-forms.text-input
                                        name="local[]"
                                        :value="old('local.' . $loop->index, $row['local'])"
                                        class="w-full mt-1"
                                    />
                                    <x-forms.input-error :messages="$errors->get('local.' . $loop->index)"/>
                                </div>

                                {{-- Comentarios--}}
                                <div class="space-y-1  col-span-1 sm:col-span-2 md:col-span-4">
                                    <x-forms.input-label for="comentarios[]" :value="__('Comentarios')" />
                                    <x-forms.text-input
                                        name="comentarios[]"
                                        :value="old('comentarios.' . $loop->index, $row['comentarios'])"
                                        class="w-full mt-1"
                                    />
                                    <x-forms.input-error :messages="$errors->get('comentarios.' . $loop->index)"/>
                                </div>

                            </div>
                        @endforeach
                    </form>
                @endif

                @if($tipoActividad == 'clase')

                    {{-- Caso para clases --}}
                    <form class="p-5" method="POST" action="{{ route('importar-clases') }}">
                        @csrf
                        <div class="flex items-center justify-center w-full mt-4 md:col-span-2">
                            <button type="submit" class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                                Guardar clases
                            </button>
                        </div>

                        @foreach($excelData as $row)
                            <h1 class="text-xl font-bold text-orange-900 mt-5 mb-3">Registro de actividad {{ $loop->iteration }}</h1>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">

                                {{-- Materia --}}
                                <div class="space-y-1">
                                    <x-forms.input-label for="materia[]" :value="__('Materia')" />
                                    <x-forms.text-input
                                        name="materia[]"
                                        :value="old('materia.' . $loop->index, $row['materia'])"
                                        class="w-full mt-1"
                                    />
                                    <x-forms.input-error :messages="$errors->get('materia.' . $loop->index)"/>
                                </div>

                                {{-- Tipo de clase --}}
                                <div class="space-y-2">
                                    <x-forms.input-label for="tipo[]" :value="__('Tipo de clase')" />
                                    <select id="tipo" name="tipo[]" class="mt-1 w-full pl-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        @foreach($tipoClases as $tipoClase)
                                            <option value="{{ $tipoClase->id }}" {{ $tipoClase->id == $row['tipo'] ? 'selected' : '' }}>
                                                {{ $tipoClase->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-forms.input-error :messages="$errors->get('modalidad')" class="mt-2" />
                                </div>

                                {{-- Numero de grupo --}}
                                <div class="space-y-1">
                                    <x-forms.input-label for="grupo[]" :value="__('Grupo')" />
                                    <x-forms.text-input
                                        type="number"
                                        name="grupo[]"
                                        :value="old('grupo.' . $loop->index, $row['grupo'])"
                                        class="w-full mt-1"
                                    />
                                    <x-forms.input-error :messages="$errors->get('grupo.' . $loop->index)"/>
                                </div>

                                {{-- Hora Inicio --}}
                                <div class="space-y-2">
                                    <x-forms.input-label for="hora_inicio[]" :value="__('Hora Inicio')" />
                                    <x-forms.text-input
                                        type="time"
                                        name="hora_inicio[]"
                                        :value="old('hora_inicio.' . $loop->index, $row['hora_inicio'])"
                                        required
                                        class="w-full mt-1"
                                    />
                                    <x-forms.input-error :messages="$errors->get('hora_inicio')" class="mt-2" />
                                </div>

                                {{-- Hora Fin --}}
                                <div class="space-y-2">
                                    <x-forms.input-label for="hora_fin[]" :value="__('Hora Fin')" />
                                    <x-forms.text-input
                                        type="time"
                                        name="hora_fin[]"
                                        :value="$row['hora_fin']"
                                        required
                                        class="w-full mt-1"
                                    />
                                    <x-forms.input-error :messages="$errors->get('hora_fin')" class="mt-2" />
                                </div>

                                {{-- Modalidad --}}
                                <div class="space-y-2">
                                    <x-forms.input-label for="modalidad[]" :value="__('Modalidad')" />
                                    <select id="modalidad" name="modalidad[]" class="mt-1 w-full pl-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        @foreach($modalidades as $modalidad)
                                            <option value="{{ $modalidad->id }}" {{ $modalidad->id == $row['modalidad'] ? 'selected' : '' }}>
                                                {{ $modalidad->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-forms.input-error :messages="$errors->get('modalidad')" class="mt-2" />
                                </div>

                                {{-- Locales --}}
                                <div class="space-y-1">
                                    <x-forms.input-label for="local[]" :value="__('Local')" />
                                    <x-forms.text-input
                                        name="local[]"
                                        :value="old('local.' . $loop->index, $row['local'])"
                                        class="w-full mt-1"
                                    />
                                    <x-forms.input-error :messages="$errors->get('local.' . $loop->index)"/>
                                </div>

                                {{-- Selección de días --}}
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Días de la Semana</label>
                                    <div class="relative">
                                        <button
                                            id="dropdownDaysButton"
                                            data-dropdown-toggle="dropdownDays{{ $loop->iteration }}"
                                            class="w-full px-4 py-2 border rounded-lg text-left focus:outline-none focus:ring"
                                            type="button">
                                            Seleccionar días
                                        </button>

                                        <div
                                            id="dropdownDays{{ $loop->iteration }}"
                                            class="hidden z-20 w-full bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700"
                                            data-popper-reference-hidden
                                            data-popper-escaped
                                            data-popper-placement="top">
                                            <ul class="p-3 space-y-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDaysButton">
                                                @foreach($dias as $dia)
                                                    <li class="flex items-center">
                                                        <input
                                                            id="checkbox-{{ $dia->nombre }}-{{ $loop->parent->iteration }}"
                                                            type="checkbox"
                                                            value="{{ $dia->id }}"
                                                            name="diasActividad[{{ $row['index'] }}][]"
                                                            @if(is_array(old('diasActividad.' . $loop->parent->index)) && in_array($dia->id, old('diasActividad.' . $loop->parent->index)))
                                                                checked
                                                            @elseif(in_array($dia->id, $row['diasActividad']))
                                                                checked
                                                            @endif
                                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
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

                            </div>
                        @endforeach
                    </form>
                @endif
            @endif

        </div>
    </div>
</x-app-layout>

<script>
    function updateFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : "Selecciona un archivo";
        document.getElementById('file-name').textContent = fileName;
    }
</script>
