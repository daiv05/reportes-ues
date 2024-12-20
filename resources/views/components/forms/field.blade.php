@props([
    'required' => false,
    'label' => '',
    'name' => '',
    'type' => 'text',
    'value' => '',
    'error' => null,
    'readonly' => false,
])

<div>
    <style>
        input[type="time"] {
            position: relative;
        }

        input[type="time"]::-webkit-calendar-picker-indicator {
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
            {{ $readonly ? 'readonly' : '' }}
            class="mt-1 block w-full rounded-md border {{ $readonly ? 'bg-gray-100' : 'border-gray-300' }} py-2 pl-3 pr-3 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
        />

        @if($type === 'time')
            <x-heroicon-o-clock class="absolute inset-y-0 end-2 flex items-center ps-3.5 pointer-events-none h-10 w-10 text-gray-500" />
        @endif
    </div>


    <div id="{{ $name }}-error" class="text-sm text-red-500">
        <x-forms.input-error :messages="$error" />
    </div>
</div>

