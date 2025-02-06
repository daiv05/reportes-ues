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
    'maxlength' => '',
    'placeholder' => '',
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
            maxlength="{{ $maxlength }}"
            placeholder="{{ $placeholder }}"
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
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function triggerValidation(input) {
            const pattern = new RegExp(input.dataset.pattern); // Obtener el patrón
            const patternMessage = input.dataset.patternMessage || 'El formato no es válido';
            let errorElement = document.getElementById(`${input.name}-pattern-error`);

            if (!pattern.test(input.value) && input.value.trim() !== '') {
                if (!errorElement) {
                    // Crear dinámicamente el contenedor de error si no existe
                    errorElement = document.createElement('div');
                    errorElement.id = `${input.name}-pattern-error`;
                    errorElement.className = 'py-1 text-[0.83rem] text-red-600 dark:text-red-400';
                    input.parentNode.appendChild(errorElement);
                }
                errorElement.textContent = patternMessage; // Mostrar el mensaje de error
            } else if (errorElement) {
                // Eliminar el mensaje si el valor es válido
                errorElement.remove();
            }
        }
        // Seleccionar todos los inputs con patrones personalizados
        document.addEventListener('input', function (event) {
            if (event.target.matches('input[data-pattern]')) {
                triggerValidation(event.target); // Validar dinámicamente al escribir
            }
        });

        document.addEventListener('reset', function (event) {
            // Eliminar todos los mensajes de error al reiniciar el formulario
            document.querySelectorAll('div[id*="pattern-error"]').forEach(function (errorElement) {
                errorElement.remove();
            });
        });
    });
</script>
