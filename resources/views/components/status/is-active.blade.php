@props([
    'active',
])

@php
    $color = '';
    $text = '';
    if (isset($active)) {
        $color = $active ? 'green' : 'red';
        $text = $active ? 'ACTIVO' : 'INACTIVO';
    }
@endphp

<div class="flex justify-center">
    <div class="bg-{{ $color }}-50 text-{{ $color }}-800 rounded-full py-2 text-center text-sm w-[120px]">
        <span class="font-medium">{{ $text }}</span>
    </div>
</div>
