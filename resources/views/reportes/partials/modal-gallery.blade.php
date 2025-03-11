<x-modal name="gallery-evidencia-modal" :show="false" maxWidth="5xl">
    <div class="flex w-full flex-col items-center p-6">
        <h2 class="text-lg font-medium text-escarlata-ues dark:text-gray-100">Evidencia del problema</h2>
        <div class="mt-4 w-full">
            <div id="controls-carousel" class="relative w-full" data-carousel="static">
                <!-- Carousel -->
                <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                    @foreach ($reporte->reporteEvidencias as $evidencia)
                        <div class="m-auto hidden duration-700 ease-in-out" data-carousel-item>
                            <img
                                src="{{ asset('storage/' . $evidencia->ruta) }}"
                                alt="{{ $evidencia->id }}"
                                class="m-auto h-full w-auto object-cover"
                            />
                        </div>
                    @endforeach
                </div>
                <!-- Slider controls -->
                <button
                    type="button"
                    class="group absolute start-0 top-0 z-30 flex h-full cursor-pointer items-center justify-center px-4 focus:outline-none"
                    data-carousel-prev
                >
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 group-hover:bg-gray-200 group-focus:outline-none group-focus:ring-4 group-focus:ring-white dark:bg-gray-800/30 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70"
                    >
                        <svg
                            class="h-4 w-4 text-black dark:text-gray-800 rtl:rotate-180"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 6 10"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 1 1 5l4 4"
                            />
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button
                    type="button"
                    class="group absolute end-0 top-0 z-30 flex h-full cursor-pointer items-center justify-center px-4 focus:outline-none"
                    data-carousel-next
                >
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 group-hover:bg-gray-200 group-focus:outline-none group-focus:ring-4 group-focus:ring-white dark:bg-gray-800/30 dark:group-hover:bg-gray-800/60 dark:group-focus:ring-gray-800/70"
                    >
                        <svg
                            class="h-4 w-4 text-black dark:text-gray-800 rtl:rotate-180"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 6 10"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m1 9 4-4-4-4"
                            />
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="flex w-full justify-center bg-gray-100 px-6 py-4 text-right dark:bg-gray-800">
        <button
            type="button"
            class="rounded bg-gray-500 px-4 py-2 text-white"
            x-on:click="$dispatch('close-modal', 'gallery-evidencia-modal')"
        >
            Cerrar
        </button>
    </div>
</x-modal>
