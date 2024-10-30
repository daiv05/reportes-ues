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

            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6">

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
            </div>
            @if(isset($excelData) && $tipoActividad === 'evento')
                <form class="p-5">
                    {{-- Caso para eventos --}}
                    @foreach($excelData as $row)
                        <h1 class="text-xl font-bold text-orange-900 mt-5 mb-3">Registro de evento {{ $loop->iteration }} - Semana {{ $row['semana'] }}</h1>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                            <div class="space-y-2">
                                <x-forms.input-label for="fecha[]" :value="__('Fecha')" />
                                <x-forms.date-input
                                    name="fecha[]"
                                    :value="$row['fecha']"
                                    required
                                    autofocus
                                    class="w-full mt-1"
                                />
                                <x-forms.input-error :messages="$errors->get('fecha')" class="mt-2" />
                            </div>

                            <div class="space-y-2">
                                <x-forms.input-label for="materia[]" :value="__('Materia')" />
                                <x-forms.text-input
                                    name="materia[]"
                                    :value="$row['codigo']"
                                    required
                                    class="w-full mt-1"
                                />
                                <x-forms.input-error :messages="$errors->get('hora_inicio')" class="mt-2" />
                            </div>

                            <div class="space-y-2">
                                <x-forms.input-label for="hora_inicio[]" :value="__('Hora Inicio')" />
                                <x-forms.text-input
                                    type="time"
                                    name="hora_inicio[]"
                                    :value="$row['hora_inicio']"
                                    required
                                    class="w-full mt-1"
                                />
                                <x-forms.input-error :messages="$errors->get('hora_inicio')" class="mt-2" />
                            </div>

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

                            <div class="space-y-2">
                                <x-forms.input-label for="evaluacion[]" :value="__('Evaluación')" />
                                <x-forms.text-input
                                    name="evaluacion[]"
                                    :value="$row['evaluacion']"
                                    required
                                    class="w-full mt-1"
                                />
                                <x-forms.input-error :messages="$errors->get('evaluacion')" class="mt-2" />
                            </div>

                            <div class="space-y-2">
                                <x-forms.input-label for="cantidad_estudiantes[]" :value="__('Cantidad de Estudiantes')" />
                                <x-forms.text-input
                                    type="number"
                                    name="cantidad_estudiantes[]"
                                    :value="$row['cantidad_estudiantes']"
                                    required
                                    class="w-full mt-1"
                                />
                                <x-forms.input-error :messages="$errors->get('cantidad_estudiantes')" class="mt-2" />
                            </div>

                            <div class="space-y-2">
                                <x-forms.input-label for="modalidad[]" :value="__('Modalidad')" />
                                <x-forms.text-input
                                    name="modalidad[]"
                                    :value="$row['modalidad']"
                                    required
                                    class="w-full mt-1"
                                />
                                <x-forms.input-error :messages="$errors->get('modalidad')" class="mt-2" />
                            </div>

                            <div class="col-span-1 space-y-2">
                                <x-forms.input-label for="local[]" :value="__('Locales')" />
                                <x-forms.text-input
                                    name="local[]"
                                    :value="$row['local']"
                                    required
                                    class="w-full mt-1"
                                />
                                <x-forms.input-error :messages="$errors->get('local')" class="mt-2" />
                            </div>

                            <div class="flex flex-col sm:col-span-2 md:col-span-4 space-y-2">
                                <x-forms.input-label for="comentarios[]" :value="__('Comentarios')" />
                                <x-forms.text-input
                                    name="comentarios[]"
                                    :value="$row['comentarios']"
                                    class="w-full mt-1"
                                />
                                <x-forms.input-error :messages="$errors->get('comentarios')" class="mt-2" />
                            </div>
                        </div>
                    @endforeach
                </form>
            @endif

            @if(isset($excelData) && $tipoActividad !== 'evento')
                <form class="p-5">
                    {{-- Caso para eventos --}}
                    @foreach($excelData as $row)
                        <h1 class="text-xl font-bold text-orange-900 mt-5 mb-3">Registro de {{ $tipoActividad }} {{ $loop->iteration }}</h1>

                        {{ json_encode($row) }}
                        </div>
                    @endforeach
                </form>
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
