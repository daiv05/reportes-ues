<!-- resources/views/components/forms/select.blade.php -->
@props([
    'required' => false,
    'label' => null,
    'name',
    'id' => null,
    'options' => [], // Array de opciones con llave => valor
    'selected' => null, // Opción seleccionada por defecto
    'error' => null,
    'onchange' => null,
    'readonly' => false,
])

@php
    $id = $id ?? $name;
@endphp

<div>
    <!-- Etiqueta del select -->
    @if($label)
        <x-forms.input-label :for="$id" :value="$label" :required="$required" />
    @endif

    <!-- Select -->
    <select name="{{ $name }}" id="{{ $id }}" @if($readonly) disabled @endif
            @if($onchange) onchange="{{ $onchange }}" @endif
            class="mt-1 block w-full rounded-md border-2 {{ $readonly ? 'bg-gray-200' : 'border-gray-100' }} {{ $error ? 'border-red-500' : 'border-gray-300' }} py-2 pl-3 pr-3 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm">
        <option value="">Seleccione una opción</option> <!-- Opción predeterminada vacía -->
        @foreach ($options as $key => $value)
            <option value="{{ $key }}" {{ $key == old($name, $selected) ? 'selected' : '' }}>
                {{ $value }}
            </option>
        @endforeach
    </select>

    <!-- Mensajes de error -->
    @if ($error)
        <x-forms.input-error id="error-{{ $name }}" :messages="$error" />
    @endif
</div>
