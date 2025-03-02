<footer>
    <div class="mx-auto w-full max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
        <div class="mb-2 flex items-center">
            <img src="{{ Vite::asset('resources/img/ues-logo.webp') }}" alt="logo" class="mr-2 h-10 w-fit" />
            <span class="mr-4 text-xl font-bold text-orange-900">{{ config('app.name') }}</span>
            <span class="text-sm text-gray-500 dark:text-gray-400 sm:text-center">
                &copy; {{ date('Y') }}
                <a href="{{ config('app.url') }}" class="hover:underline">{{ config('app.name') }}</a>
                - Todos los derechos reservados.
            </span>
        </div>
        <ul
            class="mt-3 flex flex-wrap items-center text-sm font-medium text-orange-900 dark:text-gray-400 sm:mt-0"
        >
            <li>
                <a href="https://www.fia.ues.edu.sv/" target="_blank" class="me-4 hover:underline md:me-6">FIA</a>
            </li>
            <li>
                <a href="https://eisi.fia.ues.edu.sv/" target="_blank" class="me-4 hover:underline md:me-6">EISI</a>
            </li>
            <li>
                <a href="https://www.ues.edu.sv/" target="_blank" class="me-4 hover:underline md:me-6">UES</a>
            </li>
        </ul>
    </div>
</footer>
