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
                            Mantente informado de las últimas novedades en las actividades programadas de la
                            universidad, reporta cualquier tipo de incidencia y ayuda a tus compañeros.
                        </p>
                        <div class="space-y-4">
                            <button
                                class="flex items-center gap-2 rounded border border-black bg-transparent px-4 py-2 text-black"
                            >
                                <span>Ver últimos reportes</span>
                                <svg
                                    width="20px"
                                    height="20px"
                                    viewBox="0 0 32 32"
                                    version="1.1"
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"
                                    fill="#000000"
                                >
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <title>book-album</title>
                                        <desc>Created with Sketch Beta.</desc>
                                        <defs></defs>
                                        <g
                                            id="Page-1"
                                            stroke="none"
                                            stroke-width="1"
                                            fill="none"
                                            fill-rule="evenodd"
                                            sketch:type="MSPage"
                                        >
                                            <g
                                                id="Icon-Set-Filled"
                                                sketch:type="MSLayerGroup"
                                                transform="translate(-414.000000, -101.000000)"
                                                fill="#000000"
                                            >
                                                <path
                                                    d="M418,101 C415.791,101 414,102.791 414,105 L414,126 C414,128.209 415.885,129.313 418,130 L429,133 L429,104 C423.988,102.656 418,101 418,101 L418,101 Z M442,101 C442,101 436.212,102.594 430.951,104 L431,104 L431,133 C436.617,131.501 442,130 442,130 C444.053,129.469 446,128.209 446,126 L446,105 C446,102.791 444.209,101 442,101 L442,101 Z"
                                                    id="book-album"
                                                    sketch:type="MSShapeGroup"
                                                ></path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </button>
                            <button class="flex items-center gap-2 rounded bg-red-600 px-4 py-2 text-white">
                                <span>Reportar un problema</span>
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
                            </button>
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
                        <h2 class="mb-2 text-xl font-bold text-orange-900">Consulta</h2>
                        <p class="mb-4 font-bold text-orange-900">Estate atento a cualquier cambio</p>
                        <p class="text-sm text-gray-500">
                            Revisa las actividades que se llevan acabo en cada escuela, mira el detalle de los horarios
                            y consulta cualquier cambio, cancelación, suspensiones, cambios de horario o comentarios
                            adicionales de tu instructor
                        </p>
                    </div>
                    <div class="text-center">
                        <h2 class="mb-2 text-xl font-bold text-orange-900">Comparte</h2>
                        <p class="mb-4 font-bold text-orange-900">Toca cualquier reporte y compártelo con tus amigos</p>
                        <p class="text-sm text-gray-500">
                            Comenta en actividades o problemas en la facultad. Copia y comparte con quien quieras y
                            mantén a todos informados.
                        </p>
                    </div>
                    <div class="text-center">
                        <h2 class="mb-2 text-xl font-bold text-orange-900">Mantente al día</h2>
                        <p class="mb-4 font-bold text-orange-900">Consulta y ayuda en el momento que quieras</p>
                        <p class="text-sm text-gray-500">
                            El sitio web está disponible 24/7, lo que ofrece la posibilidad de consultar como una
                            aplicación en cualquier momento del día.
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
