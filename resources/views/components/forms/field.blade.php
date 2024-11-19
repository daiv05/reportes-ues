<!-- resources/views/components/forms/field.blade.php -->
@props([
    'required' => false,
    'label' => '',
    'name' => '',
    'type' => 'text',
    'value' => '',
    'error' => null,
    'readonly' => false,
])

<div>
    <x-forms.input-label :for="$name" :value="$label" :required="$required" />
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ $value }}"
        {{ $readonly ? 'readonly' : '' }}
        class="mt-1 block w-full rounded-md border {{ $readonly ? 'bg-gray-100' : 'border-gray-300' }} py-2 pl-3 pr-3 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
    />
    <x-forms.input-error :messages="$error" />
</div>
