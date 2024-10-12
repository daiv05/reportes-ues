@props(['to', 'active', 'label'])
@php
    $textNormal = 'flex items-center w-full p-2 text-gray-600 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100';
    $textActive = 'flex items-center w-full p-2 text-gray-950 transition duration-75 rounded-lg pl-11 group';
@endphp

<li>
    <a href="{{ route($to) }}" @class([
        $textNormal => !$active,
        $textActive => $active,
    ])>
        @svg('heroicon-s-ellipsis-horizontal-circle', 'w-1 h-1', ['style' => ' '])
        <span class="ms-3">{{ $label }}</span>
    </a>
</li>
