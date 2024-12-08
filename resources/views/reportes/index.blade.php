@php
    $headers = [
        ['text' => 'Título', 'align' => 'left'],
        ['text' => 'Fecha y Hora', 'align' => 'left'],
        ['text' => 'Reportado por', 'align' => 'left'],
        ['text' => 'Entidad', 'align' => 'left'],
        ['text' => 'Tipo', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acciones', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.main tituloMenor="Últimos reportes de" tituloMayor="INCIDENCIAS EN LA FACULTAD"
                       subtitulo="Mantente pendiente de los últimos reportes notificados de tu facultad">
            <x-slot name="acciones">
                @canany(['REPORTES_CREAR'])
                    <x-button-redirect to="crear-reporte" label="Reportar"/>
                @endcanany
            </x-slot>
        </x-header.main>
    </x-slot>
    <x-container>
        <div>
            {{-- FILTROS --}}
            <x-reportes.filters ruta='reportes-generales'/>
        </div>
        <div class="overflow-x-auto">
            {{-- TABLA --}}
            <x-table.base :headers="$headers">
                @foreach ($reportes as $reporte)
                    <x-table.tr>
                        <x-table.td>{{ $reporte->titulo }}</x-table.td>
                        <x-table.td>{{ \Carbon\Carbon::parse($reporte->fecha_reporte . ' ' . $reporte->hora_reporte)->format('d/m/Y, h:i A') }}</x-table.td>
                        <x-table.td>{{ $reporte->usuarioReporta?->persona?->nombre }}
                            {{ $reporte->usuarioReporta?->persona?->apellido }}</x-table.td>
                        <x-table.td>{{ $reporte->accionesReporte?->entidadAsignada?->nombre ?? '-' }}</x-table.td>
                        <x-table.td>{{ $reporte->actividad ? 'Actividad' : 'Incidencia' }}</x-table.td>
                        <x-table.td>
                            <x-status.chips :text="$reporte->estado_ultimo_historial?->nombre ?? 'NO ASIGNADO'"
                                            class="mb-2"/>
                        </x-table.td>
                        <x-table.td justify="center">
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
        </div>
        {{-- Enlaces de paginación --}}
        <nav class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row"
             aria-label="Table navigation">
            {{ $reportes->links() }}
        </nav>
    </x-container>
</x-app-layout>
