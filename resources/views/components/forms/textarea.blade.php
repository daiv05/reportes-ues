@props([
    'required' => false,
    'label' => '',
    'name' => '',
    'rows' => 2,
    'placeholder' => '',
    'value' => '',
    'error' => null,
    'readonly' => false,
    'pattern' => null,
    'patternMessage' => 'El formato no es válido',
])

<div>
    <x-forms.input-label :for="$name" :value="$label" :required="$required" />
    <div class="relative">
        <textarea
            id="{{ $name }}"
            name="{{ $name }}"
            rows="{{ $rows }}"
            placeholder="{{ $placeholder }}"
            class="{{ $readonly ? 'bg-gray-100' : 'border-gray-300' }} mt-1 block w-full rounded-md shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
            data-pattern="{{ $pattern ?? '' }}"
            data-pattern-message="{{ $patternMessage }}"
            {{ $readonly ? 'readonly' : '' }}
        >
{{ $value }}</textarea
        >
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
            if (event.target.matches('textarea[data-pattern]')) {
                triggerValidation(event.target); // Validar dinámicamente al escribir
            }
        });
    });
</script>
