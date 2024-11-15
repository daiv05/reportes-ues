@props([
    'justify' => 'start',
    'colspan' => 1,
])

@php
    $justifyClass = match($justify) {
        'center' => 'flex justify-center',
        'start' => 'flex justify-start',
        'end' => 'flex justify-end',
        default => 'flex justify-start'
    };
@endphp

<td colspan="{{ $colspan }}" class="px-6 py-4"><div class="{{ $justifyClass }}">{{ $slot }}</div></td>
