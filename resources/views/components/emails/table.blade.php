@props([
    'headers',  // Encabezados de la tabla
])

<div class="table-container">
    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400 rtl:text-right">
        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                @foreach ($headers as $head)
                    <th scope="col" class="{{ isset($head['align']) ? 'text-' . $head['align'] : '' }} px-6 py-3">
                        {{ $head['text'] ?? '' }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @if (isset($slot))
                {{ $slot }}
            @else
                <tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                    <td colspan="{{ count($headers) }}" class="px-6 py-4">No hay datos disponibles</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
