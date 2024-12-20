<!-- resources/views/components/view/description-list.blade.php -->
@props([
    'title' => '',
    'description' => '',
    'columns' => 2, // Número de columnas por defecto
])

<div {{ $attributes->merge(['class' => 'bg-white shadow overflow-hidden sm:rounded-lg']) }}>
    <div class="px-4 py-3 sm:px-6 bg-gray-100">
        <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $title }}</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $description }}</p>
    </div>
    <div class="border-t border-gray-200">
        <!-- Aplicamos la clase grid-cols-* de forma dinámica -->
        <dl class="grid grid-cols-1 md:grid-cols-{{ $columns }} gap-x-4 gap-y-8 px-6 py-8">
            {{ $slot }}
        </dl>
    </div>
</div>
