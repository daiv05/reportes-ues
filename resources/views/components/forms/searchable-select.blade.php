@props([
    'label' => null,
    'required' => false,
    'name',
    'id' => null,
    'options' => [], // Array de opciones con llave => valor
    'selected' => null, // Opción seleccionada por defecto
    'error' => null,
    'readonly' => false,
])

@php
    $id = $id ?? $name;
@endphp

<div class="relative text-sm">
    <!-- Etiqueta del select -->
    @if($label)
        <x-forms.input-label :for="$id" :value="$label" :required="$required" />
    @endif

    <!-- Campo de búsqueda -->
    <input type="text" id="search-{{ $id }}" placeholder="Buscar..." {{ $readonly ? 'readonly' : '' }}
           class="mt-1 block w-full rounded-md border border-gray-300 py-2 pl-3 shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm {{ $readonly ? 'bg-gray-200' : 'border-gray-100' }}">

    <!-- Contenedor de opciones -->
    <ul id="dropdown-{{ $id }}"
        class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-40 overflow-y-auto hidden">
        @foreach ($options as $key => $value)
            <li class="cursor-pointer px-3 py-2 hover:bg-gray-200" data-value="{{ $key }}">
                {{ $value }}
            </li>
        @endforeach
    </ul>

    <!-- Campo oculto para almacenar el valor seleccionado -->
    <input type="hidden" name="{{ $name }}" id="{{ $id }}" value="{{ old($name, $selected) }}">

    <!-- Mensajes de error -->
    @if ($error)
        <x-forms.input-error :messages="$error" />
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-{{ $id }}');
        const dropdown = document.getElementById('dropdown-{{ $id }}');
        const hiddenInput = document.getElementById('{{ $id }}');
        const options = Array.from(dropdown.querySelectorAll('li'));

        // Mostrar el dropdown al hacer clic en el campo de búsqueda
        searchInput.addEventListener('focus', function () {
            dropdown.classList.remove('hidden');
        });

        // Filtrar opciones al escribir
        searchInput.addEventListener('input', function () {
            const searchValue = this.value.toLowerCase().trim();
            options.forEach(option => {
                const text = option.textContent.toLowerCase().trim();
                option.style.display = text.includes(searchValue) ? 'block' : 'none';
            });
        });

        // Seleccionar una opción
        options.forEach(option => {
            option.addEventListener('click', function () {
                const value = this.getAttribute('data-value');
                const text = this.textContent.trim(); // Eliminar espacios en blanco alrededor del texto

                // Actualizar el campo oculto y el input
                hiddenInput.value = value;
                searchInput.value = text;

                // Ocultar el dropdown
                dropdown.classList.add('hidden');
            });
        });

        // Ocultar el dropdown al hacer clic fuera
        document.addEventListener('click', function (event) {
            if (!dropdown.contains(event.target) && event.target !== searchInput) {
                dropdown.classList.add('hidden');
            }
        });
    });
</script>
