<!-- resources/views/components/forms/checkbox.blade.php -->
@props([
    'disabled' => false,
    'label' => null,
    'name',
    'id' => null,
    'checked' => false,
    'error' => null,
])

@php
    $id = $id ?? $name;
@endphp

<div>
    <div class="flex items-center mt-1">
        <input type="checkbox" name="{{ $name }}" id="{{ $id }}" class="form-checkbox h-4 w-4 text-red-600 border-gray-300 rounded" @disabled($disabled) {{ $checked ? 'checked' : '' }}>
        <label for="{{ $id }}" class="ml-2 block text-sm text-gray-900 dark:text-white">{{ $label }}</label>
    </div>

    <!-- Mensajes de error -->
    @if ($error)
        <x-forms.input-error :messages="$error" />
    @endif
</div>
