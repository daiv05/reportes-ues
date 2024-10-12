@php
    $headers = [
        [
            'text' => 'Nombre',
            'align' => 'left',
        ],
        [
            'text' => 'Asignaturas',
            'align' => 'left',
        ],
        [
            'text' => 'Aulas',
            'align' => 'left',
        ],
        [
            'text' => 'Responsable',
            'align' => 'left',
        ],
        [
            'text' => 'Fecha',
            'align' => 'left',
        ],
        [
            'text' => 'Horario',
            'align' => 'left',
        ],
        [
            'text' => 'Estado',
            'align' => 'center',
        ],
        [
            'text' => 'Acciones',
            'align' => 'left',
        ],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.main
            tituloMenor="Listado de"
            tituloMayor="EVENTOS DE LA FACULTAD"
            subtitulo="Mantente pendiente de los ultimos reportes notificados de tu facultad"
        >
            <x-slot name="acciones">
                <x-button-redirect to="reportes-generales" label="Ver listado de reportes" />
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
                <x-table.td>Parcial I</x-table.td>
                <x-table.td>COS115</x-table.td>
                <x-table.td>B11, C11</x-table.td>
                <x-table.td>Juan Pérez</x-table.td>
                <x-table.td>12/09/2024</x-table.td>
                <x-table.td>8:00 AM - 11:00 PM</x-table.td>
                <x-table.td>
                    <x-status.chips text="CANCELADO" color="red" />
                </x-table.td>
                <x-table.td>
                    <a href="{{ route('crear-reporte') }}" class="font-medium text-gray-700 hover:underline">
                        <x-heroicon-s-flag class="mx-2 h-4" />
                    </a>
                </x-table.td>
            </x-table.tr>
            <x-table.tr>
                <x-table.td>Laboratorio II</x-table.td>
                <x-table.td>MAT115</x-table.td>
                <x-table.td>D11, ESPINO</x-table.td>
                <x-table.td>Juan Pérez</x-table.td>
                <x-table.td>12/09/2024</x-table.td>
                <x-table.td>8:00 AM - 11:00 PM</x-table.td>
                <x-table.td>
                    <x-status.chips text="VIGENTE" color="green" />
                </x-table.td>
                <x-table.td>
                    <a href="{{ route('crear-reporte') }}" class="font-medium text-gray-700 hover:underline">
                        <x-heroicon-s-flag class="mx-2 h-4" />
                    </a>
                </x-table.td>
            </x-table.tr>
            <x-table.tr>
                <x-table.td>Conferencia I</x-table.td>
                <x-table.td>MAT115</x-table.td>
                <x-table.td>D11, ESPINO</x-table.td>
                <x-table.td>Juan Pérez</x-table.td>
                <x-table.td>12/09/2024</x-table.td>
                <x-table.td>8:00 AM - 11:00 PM</x-table.td>
                <x-table.td>
                    <x-status.chips text="CANCELADO" color="red" />
                </x-table.td>
                <x-table.td>
                    <a href="{{ route('crear-reporte') }}" class="font-medium text-gray-700 hover:underline">
                        <x-heroicon-s-flag class="mx-2 h-4" />
                    </a>
                </x-table.td>
            </x-table.tr>
        </x-table.base>
    </div>
</x-app-layout>
