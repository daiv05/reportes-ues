@props(['to', 'active', 'label'])
@php
    $textNormal = 'flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100';
    $textActive = 'flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group bg-gray-100 ';
@endphp

<li>
    <a href="{{ route($to) }}" @class([
        $textNormal => !$active,
        $textActive => $active,
    ])>
        <span class="ms-3">{{ $label }}</span>
    </a>
</li>
