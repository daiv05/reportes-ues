<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ config('app.name', 'ReportFIA') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            function toggleMenu() {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            }
        </script>
    </head>
    <body class="flex h-full flex-col bg-white">
        <header class="relative z-10 bg-orange-900 p-4 text-white">
            <nav class="container mx-auto flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img
                        src="{{ Vite::asset('resources/img/ues-logo.webp') }}"
                        alt="{{ config('app.name') . ' logo' }}"
                        class="h-10 w-fit"
                    />
                    <span class="text-xl font-bold">{{ config('app.name') }}</span>
                </div>
                <div class="hidden space-x-4 md:flex">
                    <a
                        href="{{ route('login') }}"
                        class="rounded border border-white bg-transparent px-4 py-2 text-white"
                    >
                        Iniciar sesión
                    </a>
                    <a
                        href="{{ route('register') }}"
                        class="rounded border border-white bg-transparent px-4 py-2 text-white"
                    >
                        Registrarse
                    </a>
                </div>
                <button class="md:hidden" onclick="toggleMenu()" aria-expanded="false" aria-controls="mobile-menu">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                    <span class="sr-only">Abrir menú</span>
                </button>
            </nav>
            <div id="mobile-menu" class="mt-4 hidden space-y-3 md:hidden">
                <a
                    href="{{ route('login') }}"
                    class="block rounded border border-white bg-transparent px-4 py-2 text-white"
                >
                    Iniciar sesión
                </a>
                <a
                    href="{{ route('register') }}"
                    class="block rounded border border-white bg-transparent px-4 py-2 text-white"
                >
                    Registrarse
                </a>
            </div>
        </header>

        <main class="flex-grow">
            <div class="container mx-auto px-4 py-8">
                <nav class="mb-4 flex items-center space-x-3">
                    <svg width="20px" height="20px" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M1 6V15H6V11C6 9.89543 6.89543 9 8 9C9.10457 9 10 9.89543 10 11V15H15V6L8 0L1 6Z"
                                fill="#A0A0A0"
                            ></path>
                        </g>
                    </svg>
                    <a href="#" class="text-gray-600 hover:underline">Inicio</a>
                </nav>

                <div class="mb-8 flex flex-wrap items-center rounded-lg bg-pink-100 p-8">
                    <div class="w-full pr-8 lg:w-1/2">
                        <h1 class="mb-4 text-3xl font-bold text-orange-900">
                            Centro de atención
                            <br />
                            DE REPORTES E INCIDENCIAS
                        </h1>
                        <p class="mb-4 text-gray-700">
                            Reporta cualquier tipo de incidencia y ayuda a mantener el orden y la limpieza en la
                            facultad.
                        </p>
                        <div class="space-y-4">
                            <a class="flex items-center gap-2 w-min rounded bg-red-600 px-4 py-2 text-white" href="{{ route('login') }}">
                                <span>Reportar</span>
                                <svg
                                    width="20px"
                                    height="20px"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                    stroke="#ffffff"
                                >
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path
                                            d="M12.8324 21.8013C15.9583 21.1747 20 18.926 20 13.1112C20 7.8196 16.1267 4.29593 13.3415 2.67685C12.7235 2.31757 12 2.79006 12 3.50492V5.3334C12 6.77526 11.3938 9.40711 9.70932 10.5018C8.84932 11.0607 7.92052 10.2242 7.816 9.20388L7.73017 8.36604C7.6304 7.39203 6.63841 6.80075 5.85996 7.3946C4.46147 8.46144 3 10.3296 3 13.1112C3 20.2223 8.28889 22.0001 10.9333 22.0001C11.0871 22.0001 11.2488 21.9955 11.4171 21.9858C10.1113 21.8742 8 21.064 8 18.4442C8 16.3949 9.49507 15.0085 10.631 14.3346C10.9365 14.1533 11.2941 14.3887 11.2941 14.7439V15.3331C11.2941 15.784 11.4685 16.4889 11.8836 16.9714C12.3534 17.5174 13.0429 16.9454 13.0985 16.2273C13.1161 16.0008 13.3439 15.8564 13.5401 15.9711C14.1814 16.3459 15 17.1465 15 18.4442C15 20.4922 13.871 21.4343 12.8324 21.8013Z"
                                            fill="#ffffff"
                                        ></path>
                                    </g>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="mt-8 w-full lg:mt-0 lg:w-1/2">
                        <img
                            src="{{ Vite::asset('resources/img/inicio-photo.webp') }}"
                            alt="Voluntarios"
                            class="h-auto w-full rounded-lg"
                        />
                    </div>
                </div>

                <div class="mx-auto grid w-[60%] grid-cols-1 gap-12 md:grid-cols-3">
                    <div class="text-center">
                        <h2 class="mb-2 text-xl font-bold text-orange-900">Reporta</h2>
                        <p class="mb-4 font-bold text-orange-900">Reporta cualquier problema</p>
                        <p class="text-sm text-gray-500">
                            Reporta cualquier incidencia que encuentres, desde problemas de limpieza
                            hasta problemas de infraestructura.
                        </p>
                    </div>
                    <div class="text-center">
                        <h2 class="mb-2 text-xl font-bold text-orange-900">Comparte</h2>
                        <p class="mb-4 font-bold text-orange-900">Comparte con tus compañeros</p>
                        <p class="text-sm text-gray-500">
                            Comparte y comenta los reportes con tus compañeros para que estén al tanto de los problemas
                            existentes y su solución.
                        </p>
                    </div>
                    <div class="text-center">
                        <h2 class="mb-2 text-xl font-bold text-orange-900">Consulta</h2>
                        <p class="mb-4 font-bold text-orange-900">Consulta los reportes</p>
                        <p class="text-sm text-gray-500">
                            Consulta el estado de los reportes y las incidencias que has reportado en la facultad.
                        </p>
                    </div>
                </div>
            </div>
        </main>

        <footer class="bg-gray-100 py-2">
            <div class="mx-auto w-full max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
                <div class="mb-2 flex items-center">
                    <img src="{{ Vite::asset('resources/img/ues-logo.webp') }}" alt="logo" class="mr-2 h-10 w-fit" />
                    <span class="mr-4 text-xl font-bold text-orange-900">{{ config('app.name') }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400 sm:text-center">
                        © {{ now()->year }}
                        <a href="{{ config('app.url') }}" class="hover:underline">{{ config('app.name') }}</a>
                        . Todos los derechos reservados.
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
    </body>
</html>
