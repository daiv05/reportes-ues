@props(['to', 'label'])
<a href="{{ route($to) }}">
    <x-forms.primary-button>
        <x-heroicon-s-fire class="h-4 mx-2" />
        {{ $label }}
    </x-forms.primary-button>
</a>
