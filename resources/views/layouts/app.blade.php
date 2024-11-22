@php
    use Illuminate\Support\Facades\Vite;
@endphp

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="bg-gray-100">
        @include('layouts.navigation')
        @include('layouts.aside')
        <!-- Page Content -->
        <main class="min-h-screen">
            <div id="loader" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75 z-50 hidden">
                <div class="flex flex-col items-center space-y-4">
                    <!-- Spinner -->
                    <div class="relative w-16 h-16">
                        <div class="absolute inset-0 rounded-full border-4 border-gray-400 border-t-orange-900 animate-spin"></div>
                    </div>
                    <!-- Texto -->
                    <p class="text-lg font-medium text-gray-100">Por favor, espera...</p>
                </div>
            </div>
            <div class="py-4 lg:ml-64 rounded-lg mt-6">
                <!-- Page Heading -->
                @if (isset($header))
                    <div class="pb-6 pt-12">
                        <div class="mx-auto max-w-[95%] lg:px-2">
                            <div class="overflow-hidden bg-white py-4 shadow-sm dark:bg-gray-800 sm:rounded-lg">
                                {{ $header }}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="mx-auto max-w-[95%] lg:px-2">
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="py-6 px-2">
                            <div class="overflow-auto">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div class="p-4 lg:ml-64">
            <div class="rounded-lg">
                @include('layouts.footer')
            </div>
        </div>

    </div>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script>
        var notyf = new Notyf({
            types: [{
                    type: 'success',
                    background: 'green',
                    icon: {
                        className: 'material-icons',
                        tagName: 'i',
                        text: 'check',
                        color: 'white'
                    }
                },
                {
                    type: 'info',
                    background: 'blue',
                    icon: {
                        className: 'material-icons',
                        tagName: 'i',
                        text: 'info',
                        color: 'white'
                    }
                },
                {
                    type: 'warning',
                    background: 'orange',
                    icon: {
                        className: 'material-icons',
                        tagName: 'i',
                        text: 'warning',
                        color: 'white'
                    }
                },
                {
                    type: 'error',
                    background: 'red',
                    icon: {
                        className: 'material-icons',
                        tagName: 'i',
                        text: 'error',
                        color: 'white'
                    }
                },
            ]
        });

        const noty = (content, type = 'info') => {
            notyf.open({
                type: type,
                message: content,
                duration: 5000,
                dismissible: true
            });
        }

        @if (!empty(session()->has('message')))
            noty(@json(session('message')['content']), @json(session('message')['type']) ?? 'success');
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                noty(@json($error), 'warning');
            @endforeach
        @endif
    </script>

    <script>
        const hasRole = (rol) => {
            const roles = @json(Auth::user()->roles);
            return roles.some((item) => item.name === rol);
        } 
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('import-excel');
            const loader = document.getElementById('loader');

            window.addEventListener('beforeunload', function () {
                // Mostrar el loader
                loader.classList.remove('hidden');
            });

            document.addEventListener('submit', function () {
                // Mostrar el loader
                loader.classList.remove('hidden');
            });
        });


        document.addEventListener('onload', function () {
            const loader = document.getElementById('loader');
            loader.classList.remove('hidden');
        });
    </script>

</body>

</html>
