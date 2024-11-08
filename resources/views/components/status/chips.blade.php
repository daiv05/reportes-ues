@props(['text'])

@php
    $colorClass = match($text) {
        'ASIGNADO' => 'bg-blue-800 text-blue-50',
        'EN PROCESO' => 'bg-green-800 text-green-50',
        'EN PAUSA' => 'bg-amber-800 text-amber-50',
        'COMPLETADO' => 'bg-lime-800 text-lime-50',
        'INCOMPLETO' => 'bg-orange-800 text-orange-50',
        'FINALIZADO' => 'bg-emerald-800 text-emerald-50',
        'NO APLICA' => 'bg-pink-800 text-pink-50',
        'NO ASIGNADO' => 'bg-rose-800 text-rose-50',
        default => 'bg-gray-800 text-gray-50',
    };
@endphp

<div class="{{ $colorClass }} rounded-full h-8 w-40 px-4 py-1.5 text-center text-sm overflow-visible">
    <span class="font-medium justify-center text-center ">{{ $text }}</span>
</div>
