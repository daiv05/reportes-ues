@props([
    'logoSrc' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ3JjWq5hKtAVSofTTo72ynt7SlCxi2G6WXmA&s',
    'title' => 'Asignación de Reporte',
])

<div class="header text-center">
    <img src="{{ config('app.url') . '/assets/img/ues-logo.webp' }}" class="h-36" alt="logo"  />
    <h2 class="text-xl font-semibold text-gray-800">{{ $title }}</h2>
</div>
