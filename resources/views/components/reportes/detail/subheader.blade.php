@props(['subtitle', 'icon'])
<div class="font-semibold flex flex-row gap-6">
    @svg($icon, 'w-6 h-6', ['style' => ' '])
    {{ $subtitle }}
</div>
