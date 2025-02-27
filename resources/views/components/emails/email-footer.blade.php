@props([
    'footerLinks' => [
        ['label' => 'FIA', 'url' => 'https://www.fia.ues.edu.sv/'],
        ['label' => 'EISI', 'url' => 'https://eisi.fia.ues.edu.sv/'],
        ['label' => 'UES', 'url' => 'https://www.ues.edu.sv/'],
    ],
])

<div class="footer">
    <p>&copy; {{ date('Y') . ' ' . config('app.name') }} - UES</p>
    <div>
        @foreach ($footerLinks as $link)
            <a href="{{ $link['url'] }}" class="text-red-600 hover:underline" target="_blank">{{ $link['label'] }}</a>
            @if (!$loop->last)
                |
            @endif
        @endforeach
    </div>
</div>
