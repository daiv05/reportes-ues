<!-- resources/views/components/description-list-item.blade.php -->
@props(['label'])

<div class="bg-white px-4 py-2 sm:grid sm:grid-cols-3 sm:gap-3 sm:px-6">
    <dt class="text-sm font-medium text-gray-500">{{ $label }}</dt>
    <dd class="mt-1 text-sm text-gray-900 sm:mt-0">{{ $slot }}</dd>
</div>
