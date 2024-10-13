@props([
    'text',
    'color',
])

<div class="bg-{{ $color }}-50 text-{{ $color }}-800 rounded-full px-4 py-2 text-center text-sm">
    <span class="font-medium">{{ $text }}</span>
</div>
