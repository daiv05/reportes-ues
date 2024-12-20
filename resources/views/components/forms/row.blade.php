<!-- resources/views/components/container/row.blade.php -->
@props([
    'columns' => 1,
    'fullRow' => false,
])

<div {{ $attributes->merge(['class' => $fullRow ? 'col-span-full mb-3' : "grid gap-3 md:grid-cols-$columns mb-4"]) }}>
    {{ $slot }}
</div>
