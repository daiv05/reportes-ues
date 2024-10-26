@php
    $headers = [
      ['text' => 'Título', 'align' => 'left'],
      ['text' => 'Fecha y Hora', 'align' => 'left'],
      ['text' => 'Responsable', 'align' => 'left'],
      ['text' => 'Salón', 'align' => 'left'],
      ['text' => 'Entidades', 'align' => 'left'],
      ['text' => 'Actividad', 'align' => 'left'],
      ['text' => 'Estado', 'align' => 'center'],
      ['text' => 'Acciones', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    @if (session('message'))
        <div class="alert alert-{{ session('message.type') }}">
            {{ session('message.content') }}
        </div>
    @endif
    <x-slot name="header">
        <x-header.main
            tituloMenor="Últimos reportes de"
            tituloMayor="INCIDENCIAS EN LA FACULTAD"
            subtitulo="Mantente pendiente de los últimos reportes notificados de tu facultad"
        >
            <x-slot name="acciones">
                <x-button-redirect to="crear-reporte" label="Reportar"/>
            </x-slot>
        </x-header.main>
    </x-slot>
    <div>
        {{-- FILTROS --}}
        <div class="flex-column flex flex-wrap items-center justify-between space-y-4 pb-4 sm:flex-row sm:space-y-0">
            <form method="GET" action="{{ route('reportes-generales') }}" class="flex-row flex space-x-8 mt-4">
                <div>
                    <button
                        id="dropdownRadioButton"
                        data-dropdown-toggle="dropdownRadio"
                        class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                        type="button"
                    >
                        <svg class="me-3 h-3 w-3 text-gray-500 dark:text-gray-400" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                        </svg>
                        Filtrar por
                        <svg class="ms-2.5 h-2.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownRadio"
                         class="z-10 hidden w-48 divide-y divide-gray-100 rounded-lg bg-white shadow dark:divide-gray-600 dark:bg-gray-700">
                        <ul class="space-y-1 p-3 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownRadioButton">
                            <li>
                                <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <input id="filter-radio-example-1" type="radio" value="hoy" name="filter-radio"
                                           class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800"
                                        {{ request('filter-radio') == 'hoy' ? 'checked' : '' }}/>
                                    <label for="filter-radio-example-1"
                                           class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300">Hoy</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <input id="filter-radio-example-2" type="radio" value="7_dias" name="filter-radio"
                                           class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800"
                                        {{ request('filter-radio') == '7_dias' ? 'checked' : '' }}/>
                                    <label for="filter-radio-example-2"
                                           class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300">Últimos
                                        7 días</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <input id="filter-radio-example-3" type="radio" value="30_dias" name="filter-radio"
                                           class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800"
                                        {{ request('filter-radio') == '30_dias' ? 'checked' : '' }}/>
                                    <label for="filter-radio-example-3"
                                           class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300">Últimos
                                        30 días</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <input id="filter-radio-example-4" type="radio" value="mes" name="filter-radio"
                                           class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800"
                                        {{ request('filter-radio') == 'mes' ? 'checked' : '' }}/>
                                    <label for="filter-radio-example-4"
                                           class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300">Último
                                        mes</label>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                    <input id="filter-radio-example-5" type="radio" value="anio" name="filter-radio"
                                           class="h-4 w-4 border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800"
                                        {{ request('filter-radio') == 'anio' ? 'checked' : '' }}/>
                                    <label for="filter-radio-example-5"
                                           class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300">Último
                                        año</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div
                        class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3 rtl:right-0">
                        <svg class="h-4 w-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                             viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" id="table-search" name="titulo" value="{{ request('titulo') }}"
                           class="block w-80 rounded-lg border border-gray-300 bg-gray-50 p-2 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                           placeholder="Buscar por nombre"/>
                </div>

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
                        onclick="window.location.href='{{ route('reportes-generales') }}';">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </form>
        </div>
        {{-- TABLA --}}
        <x-table.base :headers="$headers">
            @foreach($reportes as $reporte)
                <x-table.tr>
                    <x-table.td>{{ $reporte->titulo }}</x-table.td>
                    <x-table.td>{{ $reporte->fecha_reporte }} {{ $reporte->hora_reporte }}</x-table.td>
                    <x-table.td>{{ $reporte->usuarioReporta?->persona?->nombre }} {{ $reporte->usuarioReporta?->persona?->apellido }}</x-table.td>
                    <x-table.td>{{ $reporte->aula?->nombre }}</x-table.td>
                    <x-table.td>{{ $reporte->accionesReporte?->entidadAsignada?->nombre }}</x-table.td>
                    <x-table.td>{{ $reporte->actividad?->descripcion }}</x-table.td>
                    <x-table.td>
                        <x-status.chips :text="$reporte->estado_ultimo_historial?->nombre ?? 'NO ASIGNADO'"
                                        class="mb-2"/>
                    </x-table.td>
                    <x-table.td>
                        <a href="{{ route('detalle-reporte', ['id' => $reporte->id]) }}"
                           class="font-medium text-gray-700 hover:underline">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </a>
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.base>
        {{-- Enlaces de paginación --}}
        <nav class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row"
             aria-label="Table navigation">
            {{ $reportes->links() }}
        </nav>
    </div>
</x-app-layout>
