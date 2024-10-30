@props(['text'])

@php
    $colorClass = match($text) {
        'ASIGNADO' => 'bg-blue-800 text-blue-50',
        'EN PROCESO' => 'bg-green-800 text-green-50',
        'EN PAUSA' => 'bg-amber-800 text-amber-50',
        'FINALIZADO' => 'bg-lime-800 text-lime-50',
        'NO APLICA' => 'bg-pink-800 text-pink-50',
        'NO ASIGNADO' => 'bg-rose-800 text-rose-50',
        default => 'bg-gray-800 text-gray-50',
    };
@endphp

<div class="{{ $colorClass }} rounded-full px-4 py-2 text-center text-sm">
    <span class="font-medium">{{ $text }}</span>
</div>
