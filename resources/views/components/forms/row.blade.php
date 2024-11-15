<!-- resources/views/components/container/row.blade.php -->
@props([
    'columns' => 1,
    'fullRow' => false,
])

<div {{ $attributes->merge(['class' => $fullRow ? 'col-span-full mb-6' : "grid gap-6 md:grid-cols-$columns mb-4"]) }}>
    {{ $slot }}
</div>
