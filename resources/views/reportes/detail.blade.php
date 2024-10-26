<x-app-layout>
    <x-slot name="header">
        <div class="p-6 text-2xl font-bold text-red-900 dark:text-gray-100">
            {{ __('Detalle de reporte') }}
        </div>
    </x-slot>

    <div>
        <div class="flex flex-col lg:flex-row w-full">
            <!-- Columna izquierda (70%) -->
            <div class="w-full lg:w-[60%] px-8">
                <div class="mb-4">
                    <!-- Fila 1 -->
                    <div class="text-3xl font-bold ml-12 mb-8">
                        <p>{{ $reporte->titulo }}</p>
                    </div>
                </div>
                <div class="mb-4">
                    <!-- Fila 2 -->
                    <div class="font-semibold">
                        <div class="flex flex-row gap-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>
                            </svg>
                            Descripción
                        </div>
                        <div class="ml-12 mt-2">
                            <x-text-area id="descripcion" rows="8" :disabled="true">
                                {{ $reporte->descripcion }}
                            </x-text-area>
                        </div>

                    </div>
                </div>
                <div class="mb-4">
                    <!-- Fila 3 -->
                    <div class="font-semibold">
                        <div class="flex flex-row gap-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                            </svg>
                            Lugar
                        </div>
                        <div class="ml-12 mt-2">
                            <input type="text"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                   placeholder="Aula de ejemplo" value="{{ $reporte->aula?->nombre }}" disabled/>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Columna derecha (30%) -->
            <div class="w-full lg:w-[25%]">
                <div class="grid grid-cols-1 lg:grid-cols-2 grid-rows-8 lg:grid-rows-4 gap-4 p-4">
                    <div><p class="text-gray-500 font-semibold">
                            Estado
                        </p></div>
                    <div>
                        <x-status.chips :text="$reporte->estado_ultimo_historial ?? 'No asignado'"
                                        class="mb-2"/>
                    </div>
                    <div><p class="text-gray-500 font-semibold">
                            Fecha
                        </p></div>
                    <div><p class="text-black font-semibold">
                            {{ \Carbon\Carbon::parse($reporte->fecha_reporte)->format('d/m/Y') }}
                        </p></div>
                    <div><p class="text-gray-500 font-semibold">
                            Hora
                        </p></div>
                    <div><p class="text-black font-semibold">
                            {{ \Carbon\Carbon::parse($reporte->hora_reporte)->format('h:i A') }}
                        </p></div>
                    <div><p class="text-gray-500 font-semibold">
                            Encargado
                        </p></div>
                    <div><p class="text-black font-semibold">
                            {{ $reporte->usuarioReporta?->persona?->nombre }} {{ $reporte->usuarioReporta?->persona?->apellido }}
                        </p></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
