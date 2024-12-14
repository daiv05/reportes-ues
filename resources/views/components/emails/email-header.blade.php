@props([
    'logoSrc',  // La fuente de la imagen del logo
    'title' => 'Asignación de Reporte',  // Título predeterminado
])

<div class="header text-center">
    <img src="{{ $logoSrc }}" class="h-36" alt="ReportFIA Logo"  />
    <h2 class="text-xl font-semibold text-gray-800">{{ $title }}</h2>
</div>
