@php
    $headersReportesEstados = [
        ['text' => 'Estado de reporte', 'align' => 'left'],
        ['text' => 'Cantidad', 'align' => 'left'],
    ];

    $headersRecursosUtilizados = [
        ['text' => 'Recurso', 'align' => 'left'],
        ['text' => 'Utilizado', 'align' => 'left'],
        ['text' => 'Medidas utilizadas', 'align' => 'left'],
        ['text' => 'Fondo utilizados', 'align' => 'left'],
    ];

    $headersRecursosPorFondos = [
        ['text' => 'Fondo', 'align' => 'left'],
        ['text' => 'Cantidad de uso', 'align' => 'center'],
        ['text' => 'Porcentaje', 'align' => 'center'],
    ];

    $headersEmpleadosAsignaciones = [
        ['text' => 'Empleado', 'align' => 'left'],
        ['text' => 'Número de asignaciones', 'align' => 'center'],
    ];
@endphp
<x-app-layout>
    <x-slot name="header">
        <x-header.main
            tituloMenor="Estadísticas y gráficos"
            tituloMayor="DE INCIDENCIAS Y REPORTES DE LA FACULTAD"
            subtitulo="Visualiza de manera gráfica y estadística los reportes de incidencias de la facultad"
        />
    </x-slot>
    <x-container>
        {{-- Filtros --}}
        <div
            class="flex-col flex flex-wrap items-center justify-between space-y-4 pb-4 sm:flex-row sm:space-y-0 w-full">
            <form action="{{ route('estadisticas.index') }}" method="GET"
                class="flex-row flex flex-wrap items-center space-x-8 mt-4 w-full">
                <div class="flex w-full flex-col md:w-3/12 px-4 md:px-0">
                    <x-forms.row :columns="1">
                        <div class="w-full">
                            <button
                                id="dropdownRadioButton"
                                data-dropdown-toggle="dropdownRadio"
                                class="w-full mt-4 inline-flex items-center justify-between rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:hover:border-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                                type="button"
                            >
                                <div class="flex items-center">
                                    <svg class="me-3 h-3 w-3 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                                    </svg>
                                    <span id="selection" class="text-sm font-medium dark:text-gray-300">Filtrar</span>
                                </div>
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
                                            <input id="filter-radio-example-1" type="radio" value="hoy" name="filter-radio" onchange="updateSelection('Hoy')"
                                                   class="h-4 w-4 border-gray-300 bg-gray-100 text-red-600 focus:ring-2 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-red-600 dark:focus:ring-offset-gray-800"
                                                {{ request('filter-radio') == 'hoy' ? 'checked' : '' }}/>
                                            <label for="filter-radio-example-1"
                                                   class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300">Hoy</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <input id="filter-radio-example-2" type="radio" value="7_dias" name="filter-radio" onchange="updateSelection('Últimos 7 días')"
                                                   class="h-4 w-4 border-gray-300 bg-gray-100 text-red-600 focus:ring-2 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-red-600 dark:focus:ring-offset-gray-800"
                                                {{ request('filter-radio') == '7_dias' ? 'checked' : '' }}/>
                                            <label for="filter-radio-example-2"
                                                   class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300">Últimos
                                                7 días</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <input id="filter-radio-example-3" type="radio" value="30_dias" name="filter-radio" onchange="updateSelection('Últimos 30 días')"
                                                   class="h-4 w-4 border-gray-300 bg-gray-100 text-red-600 focus:ring-2 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-red-600 dark:focus:ring-offset-gray-800"
                                                {{ request('filter-radio') == '30_dias' ? 'checked' : '' }}/>
                                            <label for="filter-radio-example-3"
                                                   class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300">Últimos
                                                30 días</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <input id="filter-radio-example-4" type="radio" value="mes" name="filter-radio" onchange="updateSelection('Último mes')"
                                                   class="h-4 w-4 border-gray-300 bg-gray-100 text-red-600 focus:ring-2 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-red-600 dark:focus:ring-offset-gray-800"
                                                {{ request('filter-radio') == 'mes' ? 'checked' : '' }}/>
                                            <label for="filter-radio-example-4"
                                                   class="ms-2 w-full rounded text-sm font-medium text-gray-900 dark:text-gray-300">Último
                                                mes</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="flex items-center rounded p-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <input id="filter-radio-example-5" type="radio" value="anio" name="filter-radio"   onchange="updateSelection('Último año')"
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
                    </x-forms.row>
                </div>
                <div class="flex flex-wrap space-x-4">
                    <button type="submit"
                        class="align-middle rounded-full inline-flex items-center px-3 py-3 border border-transparent shadow-sm text-sm font-medium text-white bg-escarlata-ues hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>

                    <button type="reset"
                        class="align-middle rounded-full inline-flex items-center px-3 py-3 shadow-sm text-sm font-medium bg-white border border-gray-500 text-gray-500 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                        onclick="window.location.href='{{ route('estadisticas.index') }}';">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        {{-- REPORTES POR ESTADO --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <div class="mt-4">
                <div class="overflow-x-auto">
                    {{-- TABLA --}}
                    <x-table.base :headers="$headersReportesEstados">
                        @for($i = 0; $i < count($estados); $i++)
                            <x-table.tr>
                                <x-table.td>
                                    <x-status.chips :text="$estados[$i] ?? 'NO ASIGNADO'"
                                                    class="mb-2"/>
                                </x-table.td>
                                <x-table.td justify="center">
                                    {{ $conteoReportesPorEstado[$estados[$i]] ?? 0 }}
                                </x-table.td>
                            </x-table.tr>
                        @endfor
                    </x-table.base>
                </div>
            </div>
            <div class="col-span-1 lg:col-span-2 bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg p-2 md:p-4">
                <div class="h-auto lg:h-[30rem] m-8">
                    {!! $chartReportesEstados->container() !!}
                    {!! $chartReportesEstados->script() !!}
                </div>
            </div>
        </div>

        {{-- RECURSOS MENOS UTILIZADOS --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 mt-24">
            <div class="col-span-1 bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg p-2 md:p-4">
                <div class="bg-white pb-3">
                    <h3 class="text-2xl py-2 font-bold text-escarlata-ues dark:text-gray-300">Recursos menos utilizados</h3>
                </div>
                <div class="h-auto lg:h-[30rem] m-8">
                    {!! $chartRecursosMenosUtilizados->container() !!}
                    {!! $chartRecursosMenosUtilizados->script() !!}
                </div>
            </div>
            <div class="overflow-x-auto mt-8">
                {{-- TABLA --}}
                    <x-table.base :headers="$headersRecursosUtilizados">
                        @foreach($recursosMenosUtilizados as $recurso)
                            <x-table.tr>
                                <x-table.td>
                                    {{ $recurso['recurso_nombre'] }}
                                </x-table.td>
                                <x-table.td>
                                    {{ $recurso['cantidad'] }}
                                </x-table.td>
                                <x-table.td>
                                    {{ implode( ', ', $recurso['unidades_medida']) }}
                                </x-table.td>
                                <x-table.td>
                                    {{ implode(', ', $recurso['fondos']) }}
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </x-table.base>
                </div>
        </div>


        {{-- RECURSOS MAS UTILIZADOS --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 mt-24">
            <div class="mt-4">
                <div class="bg-white pb-3">
                    <h3 class="text-2xl py-2 font-bold text-escarlata-ues dark:text-gray-300">Recursos más utilizados</h3>
                </div>

                <div class="overflow-x-auto">
                {{-- TABLA --}}
                    <x-table.base :headers="$headersRecursosUtilizados">
                        @foreach($recursosUtilizados as $recurso)
                            <x-table.tr>
                                <x-table.td>
                                    {{ $recurso['recurso_nombre'] }}
                                </x-table.td>
                                <x-table.td>
                                    {{ $recurso['cantidad'] }}
                                </x-table.td>
                                <x-table.td>
                                    {{ implode( ', ', $recurso['unidades_medida']) }}
                                </x-table.td>
                                <x-table.td>
                                    {{ implode(', ', $recurso['fondos']) }}
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </x-table.base>
                </div>
            </div>
            <div class="col-span-1 bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg p-2 md:p-4">
                <div class="h-auto lg:h-[30rem] m-8">
                    {!! $chartRecursosUtilizados->container() !!}
                    {!! $chartRecursosUtilizados->script() !!}
                </div>
            </div>
        </div>


        {{-- RECURSOS POR FONDOS --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 mt-24">
            <div class="col-span-1 bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg p-2 md:p-4">
                <div class="bg-white pb-3">
                    <h3 class="text-2xl font-bold text-escarlata-ues dark:text-gray-300">Fondos utilizados</h3>
                </div>
                <div class="h-auto lg:h-[30rem] m-8">
                    {!! $chartRecursosPorFondos->container() !!}
                    {!! $chartRecursosPorFondos->script() !!}
                </div>
            </div>
            <div class="overflow-x-auto mt-8">
                {{-- TABLA --}}
                <x-table.base :headers="$headersRecursosPorFondos">
                    @foreach($recursosPorFondos as $fondo)
                        <x-table.tr>
                            <x-table.td>
                                {{ $fondo['nombre'] }}
                            </x-table.td>
                            <x-table.td justify="center">
                                {{ $fondo['cantidad'] }}
                            </x-table.td>
                            <x-table.td justify="center">
                                <span class="bg-red-100 text-escarlata-ues font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-red-400 border border-red-400">
                                    {{ $fondo['porcentaje'] }}%
                                </span>
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </x-table.base>
            </div>
        </div>


        {{-- EMPLEADOS CON MAS ASIGNACIONES --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 mt-24">
            <div class="mt-4">
                <div class="bg-white pb-3">
                    <h3 class="text-2xl py-2 font-bold text-escarlata-ues dark:text-gray-300">Empleados con más asignaciones</h3>
                </div>

                <div class="overflow-x-auto">
                    {{-- TABLA --}}
                    <x-table.base :headers="$headersEmpleadosAsignaciones">
                        @foreach($empleadosMasAsignaciones as $empAsignacion)
                            <x-table.tr>
                                <x-table.td>
                                    {{ $empAsignacion->empleado_nombre_completo }}
                                </x-table.td>
                                <x-table.td justify="center">
                                    {{ $empAsignacion->numero_asignaciones }}
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </x-table.base>
                </div>
            </div>
            <div class="col-span-1 bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg p-2 md:p-4">
                <div class="h-auto lg:h-[30rem] m-8">
                    {!! $chartEmpleadosMasAsignaciones->container() !!}
                    {!! $chartEmpleadosMasAsignaciones->script() !!}
                </div>
            </div>
        </div>


        {{-- EMPLEADOS CON MENOS ASIGNACIONES --}}
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 mt-24">
            <div class="col-span-1 bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg p-2 md:p-4">
                <div class="bg-white pb-3">
                    <h3 class="absolute text-2xl font-bold pb-9 bg-white text-escarlata-ues dark:text-gray-300">Empleados con menos asignaciones</h3>
                </div>
                <div class="h-auto lg:h-[30rem] m-8">
                    {!! $chartEmpleadosMenosAsignaciones->container() !!}
                    {!! $chartEmpleadosMenosAsignaciones->script() !!}
                </div>
            </div>
            <div class="overflow-x-auto mt-8">
                {{-- TABLA --}}
                <x-table.base :headers="$headersEmpleadosAsignaciones">
                    @foreach($empleadosMenosAsignaciones as $empAsignacion)
                        <x-table.tr>
                            <x-table.td>
                                {{ $empAsignacion->empleado_nombre_completo }}
                            </x-table.td>
                            <x-table.td justify="center">
                                {{ $empAsignacion->numero_asignaciones }}
                            </x-table.td>
                        </x-table.tr>
                    @endforeach
                </x-table.base>
            </div>
        </div>
    </x-container>

</x-app-layout>

<script>
    const request = (name) => {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    }

    function updateSelection(value) {
        document.getElementById('selection').innerText = value;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const filterRadio = request('filter-radio');
        if (filterRadio) {
            updateSelection(filterRadio === 'hoy' ? 'Hoy' : filterRadio === '7_dias' ? 'Últimos 7 días' : filterRadio === '30_dias' ? 'Últimos 30 días' : filterRadio === 'mes' ? 'Último mes' : 'Último año');
        }
    });
</script>
