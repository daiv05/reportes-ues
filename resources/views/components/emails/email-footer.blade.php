@props([
    'footerLinks' => [],  // Enlaces de pie de página
])

<div class="footer">
    <p>&copy; {{ date('Y') }} Universidad de El Salvador</p>
    <div>
        @foreach ($footerLinks as $link)
            <a href="{{ $link['url'] }}" class="text-red-600 hover:underline" target="_blank">{{ $link['label'] }}</a>
            @if (!$loop->last)
                |
            @endif
        @endforeach
    </div>
</div>