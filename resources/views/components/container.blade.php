<!-- resources/views/components/container.blade.php -->
<div {{ $attributes->merge(['class' => 'max-w-7xl mx-auto py-6 sm:px-6 lg:px-8']) }}>
    {{ $slot }}
</div>
