@props([
    'value',
    'required' => false,
])

<label {{ $attributes->merge(['class' => 'font-medium text-sm text-gray-700 dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
</label>
@if ($required)
    <x-forms.input-required />
@endif
