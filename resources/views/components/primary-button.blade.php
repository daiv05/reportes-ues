<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-escarlata-ues border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-escarlata-ues dark:hover:bg-white focus:bg-red-700 dark:focus:bg-white active:bg-red-900 dark:active:bg-red-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-red-800 transition ease-in-out duration-150']) }}
>
    {{ $slot }}
</button>
