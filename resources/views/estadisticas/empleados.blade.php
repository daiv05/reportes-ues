@php
    $headersEmpleadosEficiencia = [
        ['text' => 'Empleado', 'align' => 'left'],
        ['text' => 'Horas trabajadas', 'align' => 'left'],
        ['text' => 'Horas de reporte en pausa', 'align' => 'left'],
        ['text' => 'No. de reportes finalizados', 'align' => 'center'],
        ['text' => 'Índice de eficiencia', 'align' => 'center'],
    ];

    $ordenes = [
        'ASC' => 'Ascendente',
        'DESC' => 'Descendente',
    ];

    $ordenarPor = [
        'nombre' => 'Nombre',
        'horasTrabajadas' => 'Horas trabajadas',
        'horasEnPausa' => 'Horas de reporte en pausa',
        'totalReportesFinalizados' => 'No. de reportes finalizados',
        'indiceEficiencia' => 'Índice de eficiencia',
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.main tituloMenor="Estadísticas de empleados" tituloMayor="SOBRE TIEMPOS Y EFICIENCIA"
            subtitulo="Aquí encontrarás información relevante sobre los empleados." />
    </x-slot>
    <x-container>
        {{-- Filtros --}}
        <div class="flex-column flex flex-wrap items-center gap-3 space-y-4 pb-4 sm:flex-row sm:space-y-0">
        <div class="flex w-full flex-col flex-wrap items-center justify-between space-y-4 pb-4 sm:flex-row sm:space-y-0">
            <form action="{{ route('estadisticas.eficienciaEmpleados') }}" method="GET"
                class="mt-4 flex w-full flex-row flex-wrap items-center space-x-8">
                <div class="flex w-full flex-col px-4 md:w-3/12 md:px-0">
                    <x-forms.row :columns="3">
                        <x-forms.select
                            id="id_entidad"
                            label="Entidad"
                            name="id_entidad"
                            :options="$entidades"
                            selected="{{ request('id_entidad') }}"
                        />
                        <x-forms.select
                            name="orden"
                            label="Orden"
                            :options="$ordenes"
                            selected="{{ request('orden') }}"
                        />
                        <x-forms.select
                            name="orderBy"
                            label="Ordenar Por"
                            :options="$ordenarPor"
                            selected="{{ request('orderBy') }}"
                        />
                    </x-forms.row>
                    <x-forms.row :columns="3">
                        <x-forms.field
                            id="nombreEmpleado"
                            label="Nombre del empleado"
                            name="nombreEmpleado"
                            :value="request('nombreEmpleado')"
                        />
                    </x-forms.row>
                </div>
                <div class="flex flex-wrap space-x-4">
                    <button type="submit" data-tooltip-target="tooltip-aplicar-filtros"
                        class="inline-flex items-center rounded-full border border-transparent bg-escarlata-ues px-3 py-3 align-middle text-sm font-medium text-white shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>

                    <div id="tooltip-aplicar-filtros" role="tooltip"
                        class="shadow-xs tooltip z-40 inline-block rounded-lg bg-escarlata-ues px-3 py-2 text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700">
                        Aplicar filtros
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>

                    <button type="reset"
                        class="inline-flex items-center rounded-full border border-gray-500 bg-white px-3 py-3 align-middle text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                        onclick="window.location.href='{{ route('estadisticas.index') }}';"
                        data-tooltip-target="tooltip-limpiar-filtros">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div id="tooltip-limpiar-filtros" role="tooltip"
                        class="shadow-xs tooltip z-40 inline-block rounded-lg bg-gray-200 px-3 py-2 text-sm font-medium text-escarlata-ues opacity-0 transition-opacity duration-300 dark:bg-gray-700">
                        Limpiar filtros
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>
            </form>
        </div>
        </div>

        {{-- EMPLEADOS Y SU INDICE DE EFICIENCIA --}}
        <div class="mt-4 grid grid-cols-1">
            <div class="mt-4">
                <div class="bg-white pb-3">
                    <h3 class="py-2 text-2xl font-bold text-escarlata-ues dark:text-gray-300">
                        Indice de eficiencia de los empleados
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    {{-- TABLA --}}
                    <x-table.base :headers="$headersEmpleadosEficiencia">
                        @foreach ($listaEmpleados as $emp)
                            <x-table.tr>
                                <x-table.td>
                                    {{ $emp['nombre'] }}
                                </x-table.td>
                                <x-table.td justify="center">
                                    {{ $emp['horasTrabajadas'] }}
                                </x-table.td>
                                <x-table.td justify="center">
                                    {{ $emp['horasEnPausa'] }}
                                </x-table.td>
                                <x-table.td justify="center">
                                    {{ $emp['totalReportesFinalizados'] }}
                                </x-table.td>
                                <x-table.td justify="center">
                                    {{ $emp['indiceEficiencia'] }}
                                </x-table.td>
                            </x-table.tr>
                        @endforeach
                    </x-table.base>
                </div>
                <nav class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row"
                    aria-label="Table navigation">
                    {{ $listaEmpleados->links() }}
                </nav>
            </div>
            <div class="col-span-1 bg-white p-2 shadow-sm dark:bg-gray-800 sm:rounded-lg md:p-4">
                <div class="m-8 h-auto lg:h-[30rem]">
                    <canvas id="empleadosEficiencia"></canvas>
                </div>
            </div>
        </div>

        <hr class="my-8 border-gray-300 dark:border-gray-600" />

        {{-- EXPLICACION DE INDICE Y FORMA DE CALCULO --}}
        <div>
            <div class="bg-white p-4 shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <h3 class="py-2 text-md font-bold text-escarlata-ues dark:text-gray-300">
                    Nota
                </h3>
                <p class="text-base text-gray-700 dark:text-gray-300">
                    El cálculo del índice de eficiencia se realiza tomando en cuenta los tiempos de resolución
                    de las asignaciones de cada empleado y el valor estimado de resolución según la categoría del
                    reporte.
                <div class="mt-4">
                    <p class="text-base text-gray-700 dark:text-gray-300">
                        <span class="font-bold">Índice de eficiencia</span> =
                        <span class="font-bold">Tiempo máximo estimado</span> /
                        <span class="font-bold">Tiempo real (sin contar pausas)</span>
                    </p>
                </div>
                </p>
            </div>
        </div>
    </x-container>
</x-app-layout>

<script>
    const request = (name) => {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    };

    function updateSelection(value) {
        document.getElementById('selection').innerText = value;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const filterRadio = request('filter-radio');
        if (filterRadio) {
            updateSelection(
                filterRadio === 'hoy' ?
                'Hoy' :
                filterRadio === '7_dias' ?
                'Últimos 7 días' :
                filterRadio === '30_dias' ?
                'Últimos 30 días' :
                filterRadio === 'mes' ?
                'Último mes' :
                'Último año',
            );
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de empleados con más asignaciones
        const ctxEmpleadosEficiencia = document.getElementById('empleadosEficiencia').getContext('2d');
        const empleadosEficienciaChart = new Chart(ctxEmpleadosEficiencia, {
            type: @json($chartEmpleadosEficiencia['type']),
            data: {
                labels: @json($chartEmpleadosEficiencia['labels']),
                datasets: [{
                    data: @json($chartEmpleadosEficiencia['datasets']['data']),
                    backgroundColor: @json($chartEmpleadosEficiencia['datasets']['backgroundColor']),
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
        });
    });
</script>
