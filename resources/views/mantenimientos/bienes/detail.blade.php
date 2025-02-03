@php
    $headersReportes = [
        ['text' => 'ID', 'align' => 'left'],
        ['text' => 'Reporte', 'align' => 'left'],
        ['text' => 'Fecha y hora', 'align' => 'center'],
        ['text' => 'Tipo', 'align' => 'center'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acciones', 'align' => 'center'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Detalles del bien: {{ ucwords(strtolower($bien->nombre)) }}" />
    </x-slot>

    <x-container>
        <!-- Información del rol -->
        <x-view.description-list title="Información del bien" description="Detalles del bien, tipo y estado actual."
            :columns="2">
            <x-view.description-list-item label="Nombre">
                {{ ucwords(strtolower($bien->nombre)) }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Tipo">
                {{ $bien->tipoBien->nombre }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Estado">
                <div class="flex justify-start">
                    <x-status.is-bien-active :text="$bien->estadoBien->nombre" />
                </div>
            </x-view.description-list-item>

            <x-view.description-list-item label="Código">
                {{ $bien->codigo }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Descripción">
                {{ $bien->descripcion }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Fecha de creación">
                {{ $bien->created_at->format('d/m/Y H:i:s') }}
            </x-view.description-list-item>
        </x-view.description-list>

        <div class="mt-6 overflow-hidden bg-white text-center shadow sm:rounded-lg">
            <div class="bg-gray-100 px-4 py-2 sm:px-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900">Reportes relacionados</h3>
            </div>

            <div class="border-t border-gray-200">
                <x-table.base :headers="$headersReportes">
                    @foreach ($reportes as $reporte)
                        <x-table.tr>
                            <x-table.td>{{ $reporte->id }}</x-table.td>
                            <x-table.td>{{ $reporte->titulo }}</x-table.td>
                            <x-table.td>{{ \Carbon\Carbon::parse($reporte->fecha_reporte . ' ' . $reporte->hora_reporte)->format('d/m/Y, h:i A') }}</x-table.td>
                            <x-table.td>{{ $reporte->actividad ? 'Actividad' : 'Incidencia' }}</x-table.td>
                            <x-table.td justify="center">
                                @if ($reporte->no_procede === 0)
                                    <x-status.chips :text="$reporte->estado_ultimo_historial?->nombre ?? 'NO ASIGNADO'" class="mb-2" />
                                @else
                                    <x-status.chips text="NO PROCEDE" class="mb-2" />
                                @endif
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

            <nav class="mt-4 flex justify-center">
                {{ $reportes->links() }}
            </nav>
        </div>
    </x-container>
</x-app-layout>
