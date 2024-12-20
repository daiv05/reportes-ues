@php
    $headersReports = [
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
        <x-header.simple titulo="Detalles del usuario {{ ucwords(strtolower($empPuesto->usuario->persona->nombre)) }} con puesto {{ ucwords(strtolower($empPuesto->puesto->nombre)) }}" />
    </x-slot>

    <x-container>
        <!-- Información del usuario -->
        <x-view.description-list title="Información del usuario y su puesto" description="Detalles del usuario, puesto y reportes asignados." :columns="1">
            <x-view.description-list-item label="Nombre completo">
                {{ ucwords(strtolower($empPuesto->usuario->persona->nombre. ' '. $empPuesto->usuario->persona->apellido)) }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Correo electrónico">
                {{ $empPuesto->usuario->email }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Entidad relacionada">
                {{ $empPuesto->puesto->entidad->nombre }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Puesto">
                {{ $empPuesto->puesto->nombre }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Usuario">
                {{ $empPuesto->usuario->carnet }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Estado">
                <div class="flex justify-start">
                    <x-status.is-active :active="$empPuesto->activo" />
                </div>
            </x-view.description-list-item>

            <x-view.description-list-item label="Fecha de creación">
                {{ $empPuesto->usuario->created_at->format('d/m/Y H:i:s') }}
            </x-view.description-list-item>

            <x-view.description-list-item label="Última modificación">
                {{ $empPuesto->usuario->updated_at->format('d/m/Y H:i:s') }}
            </x-view.description-list-item>
        </x-view.description-list>

        <!-- Lista de roles asignados -->
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-lg text-center">
            <div class="px-4 py-2 sm:px-6 bg-gray-100">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Reportes asignados</h3>
            </div>

            <div class="border-t border-gray-200">
                <x-table.base :headers="$headersReports">
                    @foreach($empPuesto->empleadosAcciones as $empAccion)
                        <x-table.tr>
                            <x-table.td>{{ $empAccion->reporte->titulo }}</x-table.td>
                            <x-table.td>{{ \Carbon\Carbon::parse($empAccion->reporte->fecha_reporte . ' ' . $empAccion->reporte->hora_reporte)->format('d/m/Y, h:i A') }}</x-table.td>
                            <x-table.td>{{ $empAccion->reporte->usuarioReporta?->persona?->nombre }} {{ $empAccion->reporte->usuarioReporta?->persona?->apellido }}</x-table.td>
                            <x-table.td>{{ $empAccion->reporte->accionesReporte?->entidadAsignada?->nombre ?? '-' }}</x-table.td>
                            <x-table.td>{{ $empAccion->reporte->actividad ? 'Actividad' : 'General' }}</x-table.td>
                            <x-table.td>
                                <x-status.chips :text="$empAccion->reporte->estado_ultimo_historial?->nombre ?? 'NO ASIGNADO'"
                                                class="mb-2"/>
                            </x-table.td>
                            <x-table.td justify="center">
                                <a href="{{ route('detalle-reporte', ['id' => $empAccion->reporte->id]) }}"
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
        </div>
    </x-container>
</x-app-layout>

