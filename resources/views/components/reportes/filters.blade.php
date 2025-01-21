@props(['ruta' => 'reportes-generales'])

@php
    $objFiltro = [
        'hoy' => 'Hoy',
        '7_dias' => 'Últimos 7 días',
        '30_dias' => 'Últimos 30 días',
        'mes' => 'Último mes',
        'anio' => 'Último año',
    ];
@endphp

<style>
    .truncate-text {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<div class="flex flex-col space-y-4 p-4 sm:flex-row sm:space-y-0 sm:space-x-4 overflow-y-visible">
    <form method="GET" action="{{ route($ruta) }}"
          class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
        <div class="relative">
            <button
                id="dropdownRadioButton"
                data-dropdown-toggle="dropdownRadio"
                class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700 truncate-text"
                type="button"
            >
                <svg class="me-3 h-3 w-3 text-gray-500 dark:text-gray-400" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                </svg>
                {{ request('filter-radio') ? $objFiltro[request('filter-radio')] : 'Filtrar' }}
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
                                   class="h-4 w-4 border-gray-300 bg-gray-100 text-red-600 focus:ring-2 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-red-600 dark:focus:ring-offset-gray-800"
                                {{ request('filter-radio') == 'hoy' ? 'checked' : '' }}/>
                            <label for="filter-radio-example-1"
                                   class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300">Hoy</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input id="filter-radio-example-2" type="radio" value="7_dias" name="filter-radio"
                                   class="h-4 w-4 border-gray-300 bg-gray-100 text-red-600 focus:ring-2 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-red-600 dark:focus:ring-offset-gray-800"
                                {{ request('filter-radio') == '7_dias' ? 'checked' : '' }}/>
                            <label for="filter-radio-example-2"
                                   class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300">Últimos
                                7 días</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input id="filter-radio-example-3" type="radio" value="30_dias" name="filter-radio"
                                   class="h-4 w-4 border-gray-300 bg-gray-100 text-red-600 focus:ring-2 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-red-600 dark:focus:ring-offset-gray-800"
                                {{ request('filter-radio') == '30_dias' ? 'checked' : '' }}/>
                            <label for="filter-radio-example-3"
                                   class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300">Últimos
                                30 días</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input id="filter-radio-example-4" type="radio" value="mes" name="filter-radio"
                                   class="h-4 w-4 border-gray-300 bg-gray-100 text-red-600 focus:ring-2 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-red-600 dark:focus:ring-offset-gray-800"
                                {{ request('filter-radio') == 'mes' ? 'checked' : '' }}/>
                            <label for="filter-radio-example-4"
                                   class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300">Último
                                mes</label>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <input id="filter-radio-example-5" type="radio" value="anio" name="filter-radio"
                                   class="h-4 w-4 border-gray-300 bg-gray-100 text-red-600 focus:ring-2 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-red-600 dark:focus:ring-offset-gray-800"
                                {{ request('filter-radio') == 'anio' ? 'checked' : '' }}/>
                            <label for="filter-radio-example-5"
                                   class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300">Último
                                año</label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="relative">
            <select id="tipoReporte" name="tipoReporte"
                    class="block w-full sm:w-50 rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-red-500 dark:focus:ring-red-500">
                <option value="" disabled selected>Seleccionar tipo de reporte</option>
                <option value="incidencia" {{ request('tipoReporte') == 'incidencia' ? 'selected' : '' }}>Incidencia
                </option>
                <option value="actividad" {{ request('tipoReporte') == 'actividad' ? 'selected' : '' }}>Actividad
                </option>
            </select>
        </div>
        <div class="relative">
            <select id="estado" name="estado"
                    class="block w-full sm:w-50 rounded-lg border border-gray-300 bg-gray-50 p-2 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-red-500 dark:focus:ring-red-500">
                <option value="" disabled selected>Seleccionar estado del reporte</option>
                <option value="1" {{ request('estado') == '1' ? 'selected' : '' }}>ASIGNADO</option>
                <option value="3" {{ request('estado') == '3' ? 'selected' : '' }}>EN PROCESO</option>
                <option value="4" {{ request('estado') == '4' ? 'selected' : '' }}>EN PAUSA</option>
                <option value="5" {{ request('estado') == '5' ? 'selected' : '' }}>COMPLETADO</option>
                <option value="6" {{ request('estado') == '6' ? 'selected' : '' }}>FINALIZADO</option>
                <option value="7" {{ request('estado') == '7' ? 'selected' : '' }}>INCOMPLETO</option>
            </select>
        </div>
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
                   class="block w-full sm:w-80 rounded-lg border border-gray-300 bg-gray-50 p-2 ps-10 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-red-500 dark:focus:ring-red-500"
                   placeholder="Buscar por titulo"/>
        </div>

        <div class="flex space-x-2">
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
                    onclick="window.location.href='{{ route($ruta) }}';">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </form>
</div>
