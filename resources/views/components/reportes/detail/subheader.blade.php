@props([
    'subtitle',
    'icon',
    'required' => false,
])
<div class="flex flex-row gap-6 font-semibold">
    @svg($icon, 'h-6 w-6', ['style' => ' '])
    <div>
        {{ $subtitle }}
        @if ($required)
            <x-forms.input-required />
        @endif
    </div>
</div>
