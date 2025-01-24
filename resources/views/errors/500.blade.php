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
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @laravelPWA
    </head>

    <body class="bg-gray-100 font-sans text-gray-900 antialiased">
        <main class="min-h-screen">
            <div class="mt-6 flex flex-col items-center justify-center">
                <a href="/">
                    <x-application-logo class="h-20 w-20 fill-current text-gray-500" />
                </a>
            </div>
            <div class="rounded-lg py-4">
                <div class="pb-6">
                    <div class="mx-auto mt-3 max-w-[95%] lg:px-2">
                        <div class="overflow-hidden bg-white py-4 shadow-sm dark:bg-gray-800 sm:rounded-lg">
                            <div class="p-3 text-center text-xl font-bold text-red-900 dark:text-gray-100">
                                500 Internal Server Error
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mx-auto max-w-[95%] lg:px-2">
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="px-2 py-6">
                            <div class="overflow-auto">
                                <div class="container mx-auto mt-12 px-4">
                                    <div class="mb-12 text-center">
                                        <h2 class="mb-4 text-4xl font-bold text-orange-900">
                                            Ha ocurrido un error inesperado
                                        </h2>
                                        <p class="mb-16 text-xl text-gray-600">
                                            Por favor vuelve a intentarlo mas tarde
                                        </p>
                                        <a
                                            href="/"
                                            class="mt-4 rounded-lg bg-orange-900 px-4 py-2 text-white hover:bg-orange-800"
                                        >
                                            Volver a la página principal
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
