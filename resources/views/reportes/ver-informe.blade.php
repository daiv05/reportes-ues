<x-app-layout>
    <x-slot name="header">
        <div class="p-6 text-2xl font-bold text-red-900 dark:text-gray-100">
            {{ __('Informe del reporte') }}
        </div>
    </x-slot>

    <div class="flex justify-center mb-4 w-full">
        <a href="{{ route('detalle-reporte', ['id' => $reporte->id]) }}"
           class="bg-gray-500 text-white text-sm py-2 px-4 rounded hover:bg-gray-700">
            Regresar al detalle
        </a>
    </div>

    <div class="mt-12 mb-8">
        <h2 class="text-xl font-bold mb-4 lg:ml-8">Detalles del Reporte</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Campo
                    </th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Valor
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900">Título</td>
                    <td class="py-4 px-6 text-sm text-gray-500">{{ $reporte->titulo }}</td>
                </tr>
                <tr>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900">Descripción</td>
                    <td class="py-4 px-6 text-sm text-gray-500">{{ $reporte->descripcion }}</td>
                </tr>
                <tr>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900">Estado</td>
                    <td class="py-4 px-6 text-sm text-gray-500">
                        @if ($reporte->no_procede === 0)
                            <x-status.chips :text="$reporte->estado_ultimo_historial?->nombre ?? 'NO ASIGNADO'"
                                class="mb-2"/>
                        @else
                            <x-status.chips text="NO PROCEDE"
                                class="mb-2"/>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900">Fecha de Creación</td>
                    <td class="py-4 px-6 text-sm text-gray-500">{{ \Carbon\Carbon::parse($reporte->fecha_reporte)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900">Hora de Creación</td>
                    <td class="py-4 px-6 text-sm text-gray-500">{{ \Carbon\Carbon::parse($reporte->hora_reporte)->format('h:i A') }}</td>
                </tr>
                <tr>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900">Usuario</td>
                    <td class="py-4 px-6 text-sm text-gray-500">{{ $reporte->usuarioReporta?->persona?->nombre }} {{ $reporte->usuarioReporta?->persona?->apellido }}</td>
                </tr>
                <tr>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900">Duración</td>
                    <td class="py-4 px-6 text-sm text-gray-500">{{ $duracion }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-12 mb-8">
        <h2 class="text-xl font-bold mb-4 lg:ml-8">Información de la Entidad</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Campo
                    </th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Valor
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900">Entidad</td>
                    <td class="py-4 px-6 text-sm text-gray-500">{{ $entidad->nombre }}</td>
                </tr>
                <tr>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900">Subalternos</td>
                    <td class="py-4 px-6 text-sm text-gray-500">
                        @foreach ($subalternos as $subalterno)
                            {{ $subalterno->empleadoPuesto->usuario->persona->nombre }} {{ $subalterno->empleadoPuesto->usuario->persona->apellido }}
                            <br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900">Supervisor</td>
                    <td class="py-4 px-6 text-sm text-gray-500">{{ $supervisor->persona->nombre }} {{ $supervisor->persona->apellido }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-12 mb-8">
        <h2 class="text-xl font-bold mb-4 lg:ml-8">Recursos Utilizados</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Recurso
                    </th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Cantidad
                    </th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Unidad de medida
                    </th>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                        Fondo
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($recursosUsados as $recurso)
                    <tr>
                        <td class="py-4 px-6 text-sm font-medium text-gray-900">{{ $recurso->recurso->nombre }}</td>
                        <td class="py-4 px-6 text-sm text-gray-500">{{ $recurso->cantidad }}</td>
                        <td class="py-4 px-6 text-sm text-gray-500">{{ $recurso->unidadMedida->nombre }}</td>
                        <td class="py-4 px-6 text-sm text-gray-500">{{ $recurso->fondo->nombre }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
