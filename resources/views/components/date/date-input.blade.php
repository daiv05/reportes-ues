<div>
    <x-forms.input-label :for="$name" :value="$label" />
    <div class="relative max-w-sm">
        <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
            <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
            </svg>
        </div>
        <input datepicker datepicker-format="dd/mm/yyyy" name="{{ $name }}" id="{{ $name }}" type="text"
            value="{{ old($name) ? old($name) : (request($name) ?: '') }}"
            class="block w-full rounded-lg border border-gray-300 p-2.5 ps-10 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-red-500 dark:focus:ring-red-500"
            placeholder="{{ $placeholder ?? 'Seleccione una fecha' }}"
            @if($maxDate)
            datepicker-max-date="{{ \Carbon\Carbon::now()->format('d-m-Y') }}"
        @endif
           />
    </div>
    <x-forms.input-error :messages="$errors->get($name)" class="mt-2" />
</div>
