<x-general.divider />
<div class="flex flex-col lg:flex-row w-full">
    <div class="w-full lg:w-[80%] px-8">
        <div class="mt-4"></div>
        <div class="mb-4">
            <div class="text-xl font-bold ml-12 mb-8">
                <p>Seguimiento</p>
            </div>
        </div>
        <ol class="relative mx-2 border-s border-gray-200 dark:border-gray-700">
            @foreach ($reporte->accionesReporte->historialAccionesReporte as $historial)
                <li class="mb-10 ms-4">
                    <div
                        class="absolute -start-1.5 mt-1.5 h-3 w-3 rounded-full border border-white bg-gray-200 dark:border-gray-900 dark:bg-gray-700">
                    </div>
                    <div class="mb-2">
                        <x-status.chips :text="$historial->estado->nombre" class="mb-2" />
                    </div>
                    <div class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">
                        {{ \Carbon\Carbon::parse($historial->fecha_actualizacion)->format('d/m/Y') . '  ' . \Carbon\Carbon::parse($historial->hora_actualizacion)->format('h:i A') }}
                    </div>
                    @if ($historial->comentario)
                        <h3 class="text-lg font-semibold text-red-900 dark:text-white">Comentarios</h3>
                        <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
                            {{ $historial->comentario }}
                        </p>
                    @endif

                    @if ($historial->foto_evidencia)
                        <button id="{{ 'evidenciaModal-' . $historial->id }} "
                            class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:text-blue-700 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                            x-data
                            x-on:click="$dispatch('open-modal', 'evidencia-modal-@json($historial->id)')">
                            Evidencia
                            <svg class="ms-2 h-3 w-3 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </button>
                        {{-- Modal mostrar evidencia --}}
                        <x-modal name="{{ 'evidencia-modal-' . $historial->id }}" :show="false" maxWidth="xl">
                            <div class="p-6 flex flex-col items-center w-full">
                                <h2 class="text-lg font-medium text-escarlata-ues dark:text-gray-100">
                                    Evidencia
                                </h2>
                                <div class="mt-4 w-full">
                                    <div class="grid gap-4">
                                        <div>
                                            <img id="imageEvidencia" class="h-auto max-w-full rounded-lg"
                                                src="{{ asset('storage/' . $historial->foto_evidencia) }}"
                                                alt="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-center px-6 py-4 bg-gray-100 dark:bg-gray-800 text-right w-full">
                                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded"
                                    x-on:click="$dispatch('close-modal', 'evidencia-modal-@json($historial->id)')">
                                    Cerrar
                                </button>
                            </div>
                        </x-modal>
                    @endif

                    <div class="block items-center p-3 hover:bg-gray-100 dark:hover:bg-gray-700 sm:flex">
                        <img class="mb-3 me-3 h-8 w-8 rounded-full sm:mb-0" src="/assets/img/profile_1.png"
                            alt="Jese Leos image" />
                        <div class="text-gray-600 dark:text-gray-400">
                            @php
                                $persona = $historial->empleadoPuesto->usuario->persona;
                            @endphp
                            <div class="text-sm font-normal">
                                {{ $persona->nombre . ' ' . $persona->apellido }}</div>
                        </div>
                    </div>
                </li>
            @endforeach

        </ol>


    </div>
    <div class="w-full lg:w-[20%] px-8">
        <button id="abrirActualizarSeguimiento"
            class="bg-escarlata-ues text-white text-sm py-2 px-4 rounded hover:bg-red-500 flex items-center" x-data
            x-on:click="$dispatch('open-modal', 'actualizar-seguimiento-modal')">
            <p class="mr-2">Actualizar</p>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
            </svg>
        </button>


        <x-modal name="actualizar-seguimiento-modal" :show="false" maxWidth="xl">
            <form method="POST" action="{{ route('reportes.actualizarEstado', ['id' => $reporte->id]) }}"
                enctype="multipart/form-data">
                @csrf
                <div class="p-6 flex flex-col items-center w-full">
                    <h2 class="text-lg font-medium text-escarlata-ues dark:text-gray-100">
                        Actualizar seguimiento de reporte
                    </h2>
                    <div class="mt-4 w-full">
                        <label for="id_estado"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Actualizar
                            a</label>
                        <select id="id_estado" name="id_estado"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Seleccionar estado</option>
                            @foreach ($estadosPermitidos as $estado)
                                <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                            @endforeach
                        </select>
                        @include('components.forms.input-error', [
                            'messages' => $errors->get('id_estado'),
                        ])
                    </div>
                    <div class="mt-4 w-full">
                        <label for="comentarios"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Comentarios</label>
                        <textarea id="comentarios" name="comentario" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                        @include('components.forms.input-error', [
                            'messages' => $errors->get('comentario'),
                        ])
                    </div>
                    <div class="mt-4 w-full">
                        <label for="evidencia"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Evidencia</label>
                        <input type="file" id="evidencia" name="evidencia"
                            class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 rounded-md cursor-pointer focus:outline-none focus:border-indigo-500 focus:ring-indigo-500">
                        @include('components.forms.input-error', [
                            'messages' => $errors->get('evidencia'),
                        ])
                    </div>
                </div>
                <div class="flex justify-center px-6 py-4 bg-gray-100 dark:bg-gray-800 text-right w-full">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded"
                        x-on:click="$dispatch('close-modal', 'actualizar-seguimiento-modal')">
                        Cerrar
                    </button>
                    <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded ml-2">
                        Enviar
                    </button>
                </div>
            </form>
        </x-modal>
    </div>
</div>
