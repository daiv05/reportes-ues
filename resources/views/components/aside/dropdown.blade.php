@props(['id', 'active', 'icon', 'label'])
@php
    $textDropdownNormal =
        'flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100';
    $textDropdownActive =
        'flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group bg-gray-100';
    $iconDropdownNormal = 'flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900';
    $iconDropdownActive = 'flex-shrink-0 w-5 h-5 text-gray-900 transition duration-75';
@endphp

<li>
    <button type="button" @class([
        $textDropdownNormal => !$active,
        $textDropdownActive => $active,
    ])
        data-collapse-toggle="{{ $id }}">
        @svg($icon, $active ? $iconDropdownActive : $iconDropdownNormal, ['style' => ' '])
        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ $label }}</span>
        @svg('heroicon-s-chevron-down', 'w-3 h-3', ['style' => ' '])
    </button>

</li>
