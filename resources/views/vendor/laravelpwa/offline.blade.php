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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @laravelPWA
</head>

<body class="font-sans text-gray-900 antialiased bg-gray-100">
    <main class="min-h-screen">
        <div class="flex flex-col items-center mt-6 justify-center">
            <a href="/">
                <x-application-logo class="h-20 w-20 fill-current text-gray-500" />
            </a>
        </div>
        <div class="py-4 rounded-lg">
            <div class="pb-6">
                <div class="mx-auto max-w-[95%] lg:px-2 mt-3">
                    <div class="overflow-hidden bg-white py-4 shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-3 text-center text-xl font-bold text-red-900 dark:text-gray-100">
                            Offline
                        </div>
                    </div>
                </div>
            </div>
            <div class="mx-auto max-w-[95%] lg:px-2">
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="py-6 px-2">
                        <div class="overflow-auto">
                            <div class="container mx-auto mt-12 px-4">
                                <div class="text-center mb-12">
                                    <h2 class="text-4xl font-bold mb-4 text-orange-900">Actualmente no tienes conexión a
                                        internet
                                    </h2>
                                    <p class="text-xl text-gray-600 mb-8">
                                        Por favor verifica tu conexión a internet e intenta de nuevo
                                    </p>
                                    <a href="/"
                                        class="bg-orange-900 text-white px-4 py-2 rounded-lg mt-4 hover:bg-orange-800">
                                        Recargar
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
