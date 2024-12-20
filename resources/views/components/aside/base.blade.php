@props(['to', 'active', 'icon', 'label'])
@php
    $textNormal = 'flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group';
    $textActive = 'flex items-center p-2 text-gray-900 rounded-lg bg-gray-100 group';
    $iconNormal = 'w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900';
    $iconActive = 'w-5 h-5 text-gray-900 transition duration-75';
@endphp

<li>
    <a href="{{ route($to) }}" @class([
        $textNormal => !$active,
        $textActive => $active,
    ])>
        @svg($icon, $active ? $iconActive : $iconNormal, ['style' => ' '])
        <span class="ms-3">{{ $label }}</span>
    </a>
</li>
