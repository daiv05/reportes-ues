@props(['text'])

@php
    $colorClass = match($text) {
        'ASIGNADO' => 'bg-blue-100 text-blue-800',
        'EN PROCESO' => 'bg-purple-100 text-purple-800',
        'EN PAUSA' => 'bg-amber-100 text-amber-800',
        'COMPLETADO' => 'bg-lime-800 text-lime-50',
        'INCOMPLETO' => 'bg-orange-100 text-orange-800',
        'FINALIZADO' => 'bg-green-100 text-green-800',
        'NO APLICA' => 'bg-red-100 text-red-800',
        'NO ASIGNADO' => 'bg-orange-600 text-white',
        default => 'bg-gray-800 text-gray-50',
    };
@endphp

<div class="{{ $colorClass }} rounded-full h-8 w-36 px-4 py-1.5 text-center text-sm overflow-visible">
    <span class="font-medium justify-center text-center ">{{ $text }}</span>
</div>
