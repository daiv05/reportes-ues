<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>
    @notifyCss
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="bg-gray-100">
        @include('layouts.navigation2')
        @include('layouts.aside')
        <!-- Page Content -->
        <main class="min-h-screen">
            <div class="py-4 sm:ml-64">
                <div class="py-4 rounded-lg mt-6">
                    <!-- Page Heading -->
                    @if (isset($header))
                        <div class="pb-6 pt-12">
                            <div class="mx-auto max-w-[90%] sm:px-2 lg:px-4">
                                <div class="overflow-hidden bg-white py-4 shadow-sm dark:bg-gray-800 sm:rounded-lg">
                                    {{ $header }}
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="mx-auto max-w-[90%] sm:px-2 lg:px-4">
                        <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                            <div class="p-6">
                                <div class="overflow-auto">
                                    {{ $slot }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div class="p-4 sm:ml-64">
            <div class="rounded-lg">
                @include('layouts.footer')
            </div>
        </div>

    </div>
    @include('notify::components.notify')
    @notifyJs
</body>

</html>

<style lang="css">
    .notify {
        top: 50px !important;
        z-index: 9999 !important;
    }
</style>
