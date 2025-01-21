@props([
    'required' => false,
    'label' => '',
    'name' => '',
    'type' => 'text',
    'value' => '',
    'error' => null,
    'readonly' => false,
    'pattern' => null,
    'patternMessage' => 'El formato no es válido',
])

<div>
    <style>
        input[type='time'] {
            position: relative;
        }

        input[type='time']::-webkit-calendar-picker-indicator {
            display: block;
            top: 0;
            right: 0;
            height: 100%;
            width: 100%;
            position: absolute;
            background: transparent;
        }
    </style>
    <x-forms.input-label :for="$name" :value="$label" :required="$required" />
    <div class="relative">
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $name }}"
            value="{{ $value }}"
            data-pattern="{{ $pattern ?? '' }}"
            data-pattern-message="{{ $patternMessage }}"
            {{ $readonly ? 'readonly' : '' }}
            class="{{ $readonly ? 'bg-gray-100' : 'border-gray-300' }} mt-1 block w-full rounded-md border py-2 pl-3 pr-3 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
        />

        @if ($type === 'time')
            <x-heroicon-o-clock
                class="pointer-events-none absolute inset-y-0 end-2 flex h-10 w-10 items-center ps-3.5 text-gray-500"
            />
        @endif
    </div>

    <div id="{{ $name }}-error" class="text-sm text-red-500">
        <x-forms.input-error :messages="$error" />
    </div>

    <div id="{{ $name }}-pattern-error" class="py-1 text-[0.83rem] text-red-600 dark:text-red-400"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Seleccionar todos los inputs con patrones personalizados
        const inputs = document.querySelectorAll('input[data-pattern]');
        const errors = '{{ $errors }}';

        inputs.forEach((input) => {
            const errorElement = document.getElementById(`${input.name}-pattern-error`);
            const pattern = new RegExp(input.dataset.pattern); // Obtener el patrón desde el atributo
            const patternMessage = input.dataset.patternMessage; // Mensaje personalizado

            input.addEventListener('input', function () {
                if (!pattern.test(this.value) && this.value !== '') {
                    // Mostrar error si el valor no cumple el patrón
                    errorElement.style.display = 'block';
                    errorElement.textContent = patternMessage;
                } else {
                    // Ocultar error si el valor es válido
                    errorElement.style.display = 'none';
                    errorElement.textContent = '';
                }
            });
        });
    });
</script>
