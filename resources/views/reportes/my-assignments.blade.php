@php
    $headers = [
        ['text' => 'ID', 'align' => 'left'],
        ['text' => 'Título', 'align' => 'left'],
        ['text' => 'Fecha y Hora', 'align' => 'left'],
        ['text' => 'Asignado como', 'align' => 'left'],
        ['text' => 'Unidad', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
    ];
@endphp

@canany(['REPORTES_ACTUALIZAR_ESTADO', 'REPORTES_REVISION_SOLUCION'])
    @php
        $headers = [
            ['text' => 'ID', 'align' => 'left'],
            ['text' => 'Título', 'align' => 'left'],
            ['text' => 'Fecha y Hora', 'align' => 'left'],
            ['text' => 'Asignado como', 'align' => 'left'],
            ['text' => 'Unidad', 'align' => 'left'],
            ['text' => 'Estado', 'align' => 'center'],
            ['text' => 'Acciones', 'align' => 'center'],
        ];
    @endphp
@endcanany

<x-app-layout>
    <x-slot name="header">
        <x-header.main
            tituloMenor="Listado de"
            tituloMayor="ASIGNACIONES"
            subtitulo="Revisa y actualiza las incidencias asignadas por tus jefes"
        >
            <x-slot name="acciones">
                <x-button-redirect to="crear-reporte" label="Reportar" />
            </x-slot>
        </x-header.main>
    </x-slot>
    <x-container>
        {{-- FILTROS --}}
        <x-reportes.filters ruta="reportes.misAsignaciones" />
        <div class="overflow-x-auto">
            {{-- TABLA --}}
            <x-table.base :headers="$headers">
                @if ($reportes->isEmpty())
                    <x-table.td colspan="{{ count($headers) }}" justify="center">
                        <span class="text-gray-500">No se encontraron registros</span>
                    </x-table.td>
                @endif

                @foreach ($reportes as $reporte)
                    <x-table.tr>
                        <x-table.td>{{ $reporte->id }}</x-table.td>
                        <x-table.td>{{ $reporte->titulo }}</x-table.td>
                        <x-table.td>
                            {{ \Carbon\Carbon::parse($reporte->fecha_reporte)->format('d/m/Y') }}
                            {{ \Carbon\Carbon::parse($reporte->hora_reporte)->format('h:i A') }}
                        </x-table.td>
                        <x-table.td>
                            {{ $reporte->relacion_usuario['supervisor'] ? 'SUPERVISOR' : 'SUBALTERNO' }}
                        </x-table.td>
                        <x-table.td>{{ $reporte->accionesReporte?->entidadAsignada?->nombre }}</x-table.td>
                        <x-table.td justify="center">
                            @if ($reporte->no_procede === 0)
                                <x-status.chips
                                    :text="$reporte->estado_ultimo_historial?->nombre ?? 'NO ASIGNADO'"
                                    class="mb-2"
                                />
                            @else
                                <x-status.chips text="NO PROCEDE" class="mb-2" />
                            @endif
                        </x-table.td>
                        <x-table.td justify="center">
                            <div class="relative flex justify-center space-x-2">
                                @canany(['REPORTES_ACTUALIZAR_ESTADO', 'REPORTES_REVISION_SOLUCION'])
                                    <a
                                        href="{{ route('detalle-reporte', ['id' => $reporte->id]) }}"
                                        class="font-medium text-gray-700 hover:underline"
                                        data-tooltip-target="tooltip-edit-{{ $reporte->id }}"
                                    >
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

                                    <div
                                        id="tooltip-edit-{{ $reporte->id }}"
                                        role="tooltip"
                                        class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-gray-800 px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                                    >
                                        Ver detalle del reporte
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                @endcanany
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.base>
        </div>
        {{-- Enlaces de paginación --}}
        <nav
            class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row"
            aria-label="Table navigation"
        >
            {{ $reportes->links() }}
        </nav>
    </x-container>
</x-app-layout>
