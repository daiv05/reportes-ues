<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 pb-20">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <div class="pb-6 pt-12">
                    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                            {{ $header }}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <footer class="bg-gray-100 py-2">
            <div class="mx-auto w-full max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
                <div class="flex items-center mb-2 ">
                    <img src="{{ Vite::asset('resources/img/ues-logo.png') }}" alt="Reportia logo" class="h-10 w-fit mr-2">
                    <span class="font-bold text-xl text-orange-900 mr-4">ReportFIA</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400 sm:text-center">
                        © 2024
                        <a href="https://flowbite.com/" class="hover:underline">Reportfia</a>
                        . Todos los derechos reservados.
                    </span>
                </div>
                <ul
                    class="mt-3 flex flex-wrap items-center text-sm font-medium dark:text-gray-400 sm:mt-0 text-orange-900"
                >
                    <li>
                        <a href="#" class="me-4 hover:underline md:me-6">FIA - UES</a>
                    </li>
                    <li>
                        <a href="#" class="me-4 hover:underline md:me-6">Universidad</a>
                    </li>
                    <li>
                        <a href="#" class="me-4 hover:underline md:me-6">Eel</a>
                    </li>
                    <li>
                        <a href="#" class="hover:underline">Contacto</a>
                    </li>
                </ul>
            </div>
        </footer>
    </body>
</html>
