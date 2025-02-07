@props(['text'])

@php
    $colorClass = match($text) {
        'ACTIVO' => 'bg-green-50 text-green-800',
        'INACTIVO' => 'bg-red-50 text-red-800',
        'DESCARGO' => 'bg-gray-50 text-gray-800',
    };
@endphp

<div class="{{ $colorClass }} rounded-full h-8 w-36 px-4 py-1.5 text-center text-sm overflow-visible">
    <span class="font-medium justify-center text-center ">{{ $text }}</span>
</div>
