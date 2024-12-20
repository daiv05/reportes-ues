@if(isset($label))
    <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</label>
@endif
<textarea id="{{ $id }}" rows="{{ $rows }}"
          class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @if($disabled) opacity-75 @endif"
          @if(isset($placeholder)) placeholder="{{ $placeholder }}"
          @endif @if($disabled) disabled @endif>{{ $slot }}</textarea>
