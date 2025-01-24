<!-- resources/views/components/picklist/picklist.blade.php -->
@props([
    'disabled' => false,
    'items',
    'asignados' => [],
    'empleados' => false,
    'tituloDisponibles' => 'Elementos disponibles',
    'tituloAsignados' => 'Elementos asignados',
    'placeholderDisponibles' => 'Buscar...',
    'placeholderAsignados' => 'Buscar asignados...',
    'inputName' => 'items',
])

<div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4 py-4">
    <!-- Lista de items disponibles con búsqueda -->
    <div class="w-full">
        <h3 class="text-sm font-medium text-gray-700 mb-2">{{ $tituloDisponibles }}</h3>
        <input type="text"
            class="search-available mb-2 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
            placeholder="{{ $placeholderDisponibles }}">

        <ul class="available-items border border-gray-300 rounded p-2 h-48 overflow-y-auto w-full">
            @foreach ($items as $item)
                @if (!in_array($item->id, $asignados))
                    <li class="p-2 hover:bg-gray-100 cursor-pointer" data-item-id="{{ $item->id }}"
                        data-item-name="{{ $item->name }}">
                        {{ $item->name }}
                        @if ($empleados)
                            <div class="text-xs text-gray-500">{{ $item->puesto }} - {{ $item->correo }}</div>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    @php
        $controlsClass =
            'bg-red text-black p-1 rounded-full shadow hover:bg-red-600 flex items-center justify-center rotate-90 sm:rotate-0';
    @endphp

    @if (!$disabled)
        <!-- Controles para agregar y quitar items -->
        <div class="flex flex-row sm:flex-col justify-center space-x-2 sm:space-x-0 sm:space-y-2">
            <button type="button" class="add-all-items {{ $controlsClass }}">
                <x-heroicon-o-chevron-double-right class="h-4 w-4" />
            </button>
            <button type="button" class="add-item {{ $controlsClass }}">
                <x-heroicon-o-chevron-right class="h-4 w-4" />
            </button>
            <button type="button" class="remove-item {{ $controlsClass }}">
                <x-heroicon-o-chevron-left class="h-4 w-4" />
            </button>
            <button type="button" class="remove-all-items {{ $controlsClass }}">
                <x-heroicon-o-chevron-double-left class="h-4 w-4" />
            </button>
        </div>
    @endif

    <!-- Lista de items asignados con búsqueda -->
    <div class="w-full">
        <h3 class="text-sm font-medium text-gray-700 mb-2">{{ $tituloAsignados }}</h3>
        <input type="text"
            class="search-assigned mb-2 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
            placeholder="{{ $placeholderAsignados }}">

        <ul class="assigned-items border border-gray-300 rounded p-2 h-48 overflow-y-auto w-full">
            @foreach ($items as $item)
                @if (in_array($item->id, $asignados))
                    <li class="p-2 hover:bg-gray-100 cursor-pointer" data-item-id="{{ $item->id }}"
                        data-item-name="{{ $item->name }}">
                        {{ $item->name }}
                        @if ($empleados)
                            <div class="text-sm text-gray-500">{{ $item->puesto }} - {{ $item->correo }}</div>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>

<!-- Input hidden para almacenar items asignados -->
<input type="hidden" name="{{ $inputName }}" class="items-input" value="{{ implode(',', $asignados) }}">


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const availableItems = document.querySelector('.available-items');
        const assignedItems = document.querySelector('.assigned-items');
        const itemsInput = document.querySelector('.items-input');
        const addItemButton = document.querySelector('.add-item');
        const removeItemButton = document.querySelector('.remove-item');
        const addAllItemsButton = document.querySelector('.add-all-items');
        const removeAllItemsButton = document.querySelector('.remove-all-items');

        // Función para mover un elemento seleccionado de una lista a otra
        function moveItem(fromList, toList) {
            const selectedItem = fromList.querySelector('.selected');
            if (selectedItem) {
                toList.appendChild(selectedItem);
                selectedItem.classList.remove('selected', 'bg-gray-200', 'font-bold');
                updateItemsInput();
            }
        }

        // Función para mover todos los elementos de una lista a otra
        function moveAllItems(fromList, toList) {
            const items = Array.from(fromList.querySelectorAll('li'));
            items.forEach(item => {
                toList.appendChild(item);
            });
            updateItemsInput();
        }

        // Actualizar el campo oculto con los IDs de los elementos asignados
        function updateItemsInput() {
            const itemIds = Array.from(assignedItems.querySelectorAll('li'))
                .map(li => li.getAttribute('data-item-id'));
            itemsInput.value = itemIds.join(',');
        }

        // Filtrar los elementos según el texto ingresado en el input de búsqueda
        function filterItems(searchInput, list) {
            const filter = searchInput.value.toLowerCase();
            Array.from(list.querySelectorAll('li')).forEach(item => {
                const itemName = item.getAttribute('data-item-name').toLowerCase();
                if (itemName.includes(filter)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Eventos para mover elementos individuales
        addItemButton.addEventListener('click', (event) => {
            event.preventDefault();
            moveItem(availableItems, assignedItems);
        });

        removeItemButton.addEventListener('click', (event) => {
            event.preventDefault();
            moveItem(assignedItems, availableItems);
        });

        // Eventos para mover todos los elementos
        addAllItemsButton.addEventListener('click', (event) => {
            event.preventDefault();
            moveAllItems(availableItems, assignedItems);
        });

        removeAllItemsButton.addEventListener('click', (event) => {
            event.preventDefault();
            moveAllItems(assignedItems, availableItems);
        });

        // Selección de elemento en las listas
        availableItems.addEventListener('click', (e) => {
            if (e.target.tagName === 'LI') {
                clearSelection(availableItems);
                e.target.classList.add('selected', 'bg-gray-200', 'font-bold');
            }
        });

        assignedItems.addEventListener('click', (e) => {
            if (e.target.tagName === 'LI') {
                clearSelection(assignedItems);
                e.target.classList.add('selected', 'bg-gray-200', 'font-bold');
            }
        });

        // Función para limpiar la selección en una lista
        function clearSelection(list) {
            Array.from(list.children).forEach(item => {
                item.classList.remove('selected', 'bg-gray-200', 'font-bold');
            });
        }

        // Búsqueda en la lista de elementos disponibles
        const searchAvailable = document.querySelector('.search-available');
        searchAvailable.addEventListener('input', () => {
            filterItems(searchAvailable, availableItems);
        });

        // Búsqueda en la lista de elementos asignados
        const searchAssigned = document.querySelector('.search-assigned');
        searchAssigned.addEventListener('input', () => {
            filterItems(searchAssigned, assignedItems);
        });
    });
</script>
