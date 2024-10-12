@php
    $headers = [
        ['text' => 'Título', 'align' => 'left'],
        ['text' => 'Fecha y Hora', 'align' => 'left'],
        ['text' => 'Responsable', 'align' => 'left'],
        ['text' => 'Salón', 'align' => 'left'],
        ['text' => 'Departamento', 'align' => 'left'],
        ['text' => 'Actividad', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acciones', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.main
            tituloMenor="Últimos reportes de"
            tituloMayor="INCIDENCIAS EN LA FACULTAD"
            subtitulo="Mantente pendiente de los ultimos reportes notificados de tu facultad"
        >
            <x-slot name="acciones">
                <x-button-redirect to="crear-reporte" label="Reportar" />
            </x-slot>
        </x-header.main>
    </x-slot>
    <div>
        {{-- FILTROS --}}
        <div class="flex-column flex flex-wrap items-center justify-between space-y-4 pb-4 sm:flex-row sm:space-y-0">
            <div>
                <button
                    id="dropdownRadioButton"
                    data-dropdown-toggle="dropdownRadio"
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                    type="button"
                >
                    <svg
                        class="me-3 h-3 w-3 text-gray-500 dark:text-gray-400"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"
                        />
                    </svg>
                    Ultimos 30 dias
                    <svg
                        class="ms-2.5 h-2.5 w-2.5"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 10 6"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m1 1 4 4 4-4"
                        />
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div
                    id="dropdownRadio"
                    class="z-10 hidden w-48 divide-y divide-gray-100 rounded-lg bg-white shadow dark:divide-gray-600 dark:bg-gray-700"
                    data-popper-reference-hidden=""
                    data-popper-escaped=""
                    data-popper-placement="top"
                    style="
                        position: absolute;
                        inset: auto auto 0px 0px;
                        margin: 0px;
                        transform: translate3d(522.5px, 3847.5px, 0px);
                    "
                >
                    <ul
                        class="space-y-1 p-3 text-sm text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdownRadioButton"
                    >
                        <li>
                            <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                <input
                                    id="filter-radio-example-1"
                                    type="radio"
                                    value=""
                                    name="filter-radio"
                                    class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800"
                                />
                                <label
                                    for="filter-radio-example-1"
                                    class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300"
                                >
                                    Hoy
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                <input
                                    checked=""
                                    id="filter-radio-example-2"
                                    type="radio"
                                    value=""
                                    name="filter-radio"
                                    class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800"
                                />
                                <label
                                    for="filter-radio-example-2"
                                    class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300"
                                >
                                    Ultimos 7 dias
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                <input
                                    id="filter-radio-example-3"
                                    type="radio"
                                    value=""
                                    name="filter-radio"
                                    class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800"
                                />
                                <label
                                    for="filter-radio-example-3"
                                    class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300"
                                >
                                    Ultimos 30 dias
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                <input
                                    id="filter-radio-example-4"
                                    type="radio"
                                    value=""
                                    name="filter-radio"
                                    class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800"
                                />
                                <label
                                    for="filter-radio-example-4"
                                    class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300"
                                >
                                    Ultimo mes
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                <input
                                    id="filter-radio-example-5"
                                    type="radio"
                                    value=""
                                    name="filter-radio"
                                    class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800"
                                />
                                <label
                                    for="filter-radio-example-5"
                                    class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300"
                                >
                                    Ultimo año
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <label for="table-search" class="sr-only">Search</label>
            <div class="relative">
                <div
                    class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3 rtl:right-0"
                >
                    <svg
                        class="h-5 w-5 text-gray-500 dark:text-gray-400"
                        aria-hidden="true"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                </div>
                <input
                    type="text"
                    id="table-search"
                    class="block w-80 rounded-lg border border-gray-300 bg-gray-50 p-2 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                    placeholder="Buscar por nombre"
                />
            </div>
        </div>
        {{-- TABLA --}}
        <x-table.base :headers="$headers">
            <x-table.tr>
                <x-table.td>Reunión de Proyecto</x-table.td>
                <x-table.td>2023-10-01 10:00</x-table.td>
                <x-table.td>Juan Pérez</x-table.td>
                <x-table.td>Aula 101</x-table.td>
                <x-table.td>Ingeniería</x-table.td>
                <x-table.td>Reunión</x-table.td>
                <x-table.td>
                    <div
                        class="mb-2 rounded-full bg-red-50 px-4 py-2 text-center text-sm text-red-800 dark:bg-gray-800 dark:text-red-400"
                    >
                        <span class="font-medium">PENDIENTE</span>
                    </div>
                </x-table.td>
                <x-table.td>
                    <a href="#" class="font-medium text-gray-700 hover:underline">
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"
                            ></path>
                        </svg>
                    </a>
                </x-table.td>
            </x-table.tr>
            <x-table.tr>
                <x-table.td>Clase de Matemáticas</x-table.td>
                <x-table.td>2023-10-02 08:00</x-table.td>
                <x-table.td>María López</x-table.td>
                <x-table.td>Aula 202</x-table.td>
                <x-table.td>Matemáticas</x-table.td>
                <x-table.td>Clase</x-table.td>
                <x-table.td>
                    <div
                        class="mb-2 rounded-full bg-green-50 px-4 py-2 text-center text-sm text-green-800 dark:bg-green-800 dark:text-green-400"
                    >
                        <span class="font-medium">FINALIZADO</span>
                    </div>
                </x-table.td>
                <x-table.td>
                    <a href="#" class="font-medium text-gray-700 hover:underline">
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"
                            ></path>
                        </svg>
                    </a>
                </x-table.td>
            </x-table.tr>
            <x-table.tr>
                <x-table.td>Taller de Programación</x-table.td>
                <x-table.td>2023-10-03 14:00</x-table.td>
                <x-table.td>Carlos García</x-table.td>
                <x-table.td>Laboratorio 1</x-table.td>
                <x-table.td>Informática</x-table.td>
                <x-table.td>Taller</x-table.td>
                <x-table.td>
                    <div
                        class="mb-2 rounded-full bg-purple-50 px-4 py-2 text-center text-sm text-purple-800 dark:bg-purple-800 dark:text-purple-400"
                    >
                        <span class="font-medium">EN PROCESO</span>
                    </div>
                </x-table.td>
                <x-table.td>
                    <a href="#" class="font-medium text-gray-700 hover:underline">
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"
                            ></path>
                        </svg>
                    </a>
                </x-table.td>
            </x-table.tr>
            <x-table.tr>
                <x-table.td>Seminario de Física</x-table.td>
                <x-table.td>2023-10-04 09:00</x-table.td>
                <x-table.td>Ana Martínez</x-table.td>
                <x-table.td>Aula 303</x-table.td>
                <x-table.td>Física</x-table.td>
                <x-table.td>Seminario</x-table.td>
                <x-table.td>
                    <div
                        class="mb-2 rounded-full bg-green-50 px-4 py-2 text-center text-sm text-green-800 dark:bg-green-800 dark:text-green-400"
                    >
                        <span class="font-medium">FINALIZADO</span>
                    </div>
                </x-table.td>
                <x-table.td>
                    <a href="#" class="font-medium text-gray-700 hover:underline">
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"
                            ></path>
                        </svg>
                    </a>
                </x-table.td>
            </x-table.tr>
            <x-table.tr>
                <x-table.td>Conferencia de Química</x-table.td>
                <x-table.td>2023-10-05 11:00</x-table.td>
                <x-table.td>Luis Fernández</x-table.td>
                <x-table.td>Aula Magna</x-table.td>
                <x-table.td>Química</x-table.td>
                <x-table.td>Conferencia</x-table.td>
                <x-table.td>
                    <div
                        class="mb-2 rounded-full bg-purple-50 px-4 py-2 text-center text-sm text-purple-800 dark:bg-purple-800 dark:text-purple-400"
                    >
                        <span class="font-medium">EN PROCESO</span>
                    </div>
                </x-table.td>
                <x-table.td>
                    <a href="#" class="font-medium text-gray-700 hover:underline">
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"
                            ></path>
                        </svg>
                    </a>
                </x-table.td>
            </x-table.tr>
            <x-table.tr>
                <x-table.td>Examen de Historia</x-table.td>
                <x-table.td>2023-10-06 13:00</x-table.td>
                <x-table.td>Laura Gómez</x-table.td>
                <x-table.td>Aula 404</x-table.td>
                <x-table.td>Historia</x-table.td>
                <x-table.td>Examen</x-table.td>
                <x-table.td>
                    <div
                        class="mb-2 rounded-full bg-purple-50 px-4 py-2 text-center text-sm text-purple-800 dark:bg-purple-800 dark:text-purple-400"
                    >
                        <span class="font-medium">EN PROCESO</span>
                    </div>
                </x-table.td>
                <x-table.td>
                    <a href="#" class="font-medium text-gray-700 hover:underline">
                        <svg
                            class="h-6 w-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"
                            ></path>
                        </svg>
                    </a>
                </x-table.td>
            </x-table.tr>
        </x-table.base>
    </div>
</x-app-layout>
