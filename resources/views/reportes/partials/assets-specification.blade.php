@php
    $tiposBienes = App\Models\Reportes\TipoBien::all();

    $headersBienes = [
        ['text' => 'Código', 'align' => 'left'],
        ['text' => 'Nombre', 'align' => 'left'],
        ['text' => 'Acciones', 'align' => 'center'],
    ];
@endphp
<div>
    {{-- Busqueda por Tipo de bien y nombre --}}
    <div class="flex flex-row justify-center md:justify-start space-x-2">
        <label class="p-2.5">Filtrar:</label>
        <select id="tipoBien"
            class="max-w-80 border border-gray-300 text-gray-900 focus:border-red-500 focus:outline-none focus:ring-red-500 text-sm rounded-lg block w-full p-2.5">
            <option value="" disabled selected>Seleccionar tipo</option>
            @foreach ($tiposBienes as $tipo)
                <option value="{{ $tipo->id }}">
                    {{ $tipo->nombre }}
                </option>
            @endforeach
        </select>
        <input type="text" id="nombre-busqueda-bienes" name="nombre"
            class="block w-full sm:w-80 rounded-lg border border-gray-300 p-2 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-red-500 dark:focus:ring-red-500"
            placeholder="Nombre/Código" />
    </div>
    <div class="my-4">
        <div class="overflow-x-auto">
            {{-- TABLA --}}
            <x-table.base :headers="$headersBienes">
                <x-table.tr>
                    <x-table.td>LUM-B11</x-table.td>
                    <x-table.td>Luminaria B11</x-table.td>
                    <x-table.td justify="center">
                        <x-heroicon-o-check-badge class="h-6 w-6 text-gray-700 hover:text-green-500 cursor-pointer" />
                    </x-table.td>
                </x-table.tr>
                <x-table.tr>
                    <x-table.td>LUM-C11-1</x-table.td>
                    <x-table.td>Luminaria Baños C11</x-table.td>
                    <x-table.td justify="center">
                        <x-heroicon-o-check-badge class="h-6 w-6 text-gray-700 hover:text-green-500 cursor-pointer" />
                    </x-table.td>
                </x-table.tr>
                <x-table.tr>
                    <x-table.td>LUM-AA-1</x-table.td>
                    <x-table.td>Luminaria Académica 1</x-table.td>
                    <x-table.td justify="center">
                        <x-heroicon-o-check-badge class="h-6 w-6 text-gray-700 hover:text-green-500 cursor-pointer" />
                    </x-table.td>
                </x-table.tr>
            </x-table.base>
        </div>
    </div>
    <div class="mt-8">
        <span class="text-gray-600">Registros seleccionados</span>
        <div class="overflow-x-auto mt-4">
            {{-- TABLA --}}
            <x-table.base :headers="$headersBienes">
                <x-table.tr>
                    <x-table.td>LUM-B11</x-table.td>
                    <x-table.td>Luminaria B11</x-table.td>
                    <x-table.td justify="center">
                        <x-heroicon-o-x-circle class="h-6 w-6 text-gray-700 hover:text-red-500 cursor-pointer" />
                    </x-table.td>
                </x-table.tr>
            </x-table.base>
        </div>
    </div>
</div>
