@props([
    'active',
])

@php
    $color = '';
    $text = '';
    if (isset($active)) {
        $color = $active ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800';
        $text = $active ? 'ACTIVO' : 'INACTIVO';
    }
@endphp

<div class="flex justify-center">
    <div class="{{ $color }} rounded-full py-2 text-center text-sm w-[120px]">
        <span class="font-medium">{{ $text }}</span>
    </div>
</div>
