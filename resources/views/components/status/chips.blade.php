@props([
    'text',
    'color' => match($text) {
        'Asignado' => 'blue',
        'En proceso' => 'green',
        'En pausa' => 'amber',
        'Finalizado' => 'lime',
        'No aplica' => 'pink',
        'No asignado' => 'rose',
        default => 'gray',
    },
])

<div
    class="bg-{{ $color }}-50 text-{{ $color }}-800 rounded-full px-4 py-2 text-center text-sm">
    <span class="font-medium">{{ $text }}</span>
</div>
