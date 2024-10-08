@props(['type' => 'info', 'message'])

@php
    $alertColors = [
        'success' => 'bg-green-100 border border-green-400 text-green-700',
        'error' => 'bg-red-100 border border-red-400 text-red-700',
        'warning' => 'bg-yellow-100 border border-yellow-400 text-yellow-700',
        'info' => 'bg-blue-100 border border-blue-400 text-blue-700',
    ];
@endphp

@if ($message)
    <div class="{{ $alertColors[$type] }} px-4 py-3 rounded relative my-4" role="alert">
        <strong class="font-bold">
            @if ($type == 'success')
                ¡Éxito!
            @elseif($type == 'error')
                ¡Error!
            @elseif($type == 'warning')
                ¡Advertencia!
            @else
                Información
            @endif
        </strong>
        <span class="block sm:inline">{{ $message }}</span>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 close-alert" aria-label="Cerrar">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const closeButtons = document.querySelectorAll('.close-alert');
        closeButtons.forEach(function(button) {
            button.addEventListener('click', function () {
                this.closest('div[role="alert"]').style.display = 'none';
            });
        });
    });
</script>
