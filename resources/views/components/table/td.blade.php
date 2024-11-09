@props([
    'justify' => 'start',
])

@php
    $justifyClass = match($justify) {
        'center' => 'flex justify-center',
        'start' => 'flex justify-start',
        'end' => 'flex justify-end',
        default => 'flex justify-start'
    };
@endphp

<td class="px-6 py-4"><div class="{{ $justifyClass }}">{{ $slot }}</div></td>
