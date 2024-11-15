<ol class="relative mx-2 border-s border-gray-200 dark:border-gray-700">
    @foreach ($reporte->accionesReporte->historialAccionesReporte as $historial)
    <div class="mb-2">
        <x-status.chips :text="$historial->estado->nombre" class="mb-2" />
    </div>
        <li class="mb-10 ms-4">
            <div
                class="absolute -start-1.5 mt-1.5 h-3 w-3 rounded-full border border-white bg-gray-200 dark:border-gray-900 dark:bg-gray-700">
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
                    x-on:click="() => {
                        $dispatch('open-modal', 'evidencia-modal-@json($historial->id)');
                    }">
                    Evidencia
                    <svg class="ms-2 h-3 w-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
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
                                        src="{{ asset('storage/' . $historial->foto_evidencia) }}" alt="" />
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
                    <div class="text-sm font-normal">{{ $persona->nombre . ' ' . $persona->apellido }}</div>
                </div>
            </div>
        </li>
    @endforeach
</ol>
