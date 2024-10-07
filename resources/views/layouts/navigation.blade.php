<nav class="border-orange-200 bg-orange-900 dark:bg-gray-900">
    <div class="mx-auto flex max-w-screen-xl flex-wrap items-center justify-between p-4">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ Vite::asset('resources/img/ues-logo.png') }}" class="h-10" alt="Reportfia Logo" />
            <span class="self-center whitespace-nowrap text-2xl font-semibold text-white">Reportfia</span>
        </a>
        <div class="flex items-center space-x-3 md:order-2 md:space-x-0 rtl:space-x-reverse">
            <button
                type="button"
                class="flex rounded-full bg-gray-800 text-sm focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 md:me-0"
                id="user-menu-button"
                aria-expanded="false"
                data-dropdown-toggle="user-dropdown"
                data-dropdown-placement="bottom"
            >
                <span class="sr-only">Abrir menú perfil</span>
                <img
                    class="h-8 w-8 rounded-full"
                    src="{{ Vite::asset('resources/img/perfil-default.png') }}"
                    alt="user photo"
                />
            </button>
            <!-- Dropdown menu -->
            <div
                class="z-50 my-4 hidden list-none divide-y divide-gray-100 rounded-lg bg-white text-base shadow dark:divide-gray-600 dark:bg-gray-700"
                id="user-dropdown"
            >
                <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->carnet }}</span>
                    <span class="block truncate text-sm text-gray-500 dark:text-gray-400">
                        {{ Auth::user()->email }}
                    </span>
                </div>
                <ul class="py-2" aria-labelledby="user-menu-button">
                    <li>
                        <a
                            href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white"
                        >
                            Perfil
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white"
                            >
                                Salir
                            </a>
                        </form>
                    </li>
                </ul>
            </div>
            <button
                data-collapse-toggle="navbar-user"
                type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-lg p-2 text-sm text-white hover:bg-gray-100 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-gray-200 md:hidden"
                aria-controls="navbar-user"
                aria-expanded="false"
            >
                <span class="sr-only">Abrir menú principal</span>
                <svg
                    class="h-5 w-5"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 17 14"
                >
                    <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15"
                    />
                </svg>
            </button>
        </div>
        <div class="hidden w-full items-center justify-between md:order-1 md:flex md:w-auto" id="navbar-user">
            <ul
                class="mt-4 flex flex-col rounded-lg font-medium md:mt-0 md:flex-row md:space-x-8 md:p-0 rtl:space-x-reverse"
            >
                <li>
                    <a
                        href="{{ route('dashboard') }}"
                        @class([
                            'block rounded px-3 py-2 text-slate-200 hover:text-white md:p-0' => ! request()->routeIs('dashboard'),
                            'block rounded px-3 py-2 text-white underline underline-offset-8 md:bg-transparent md:p-0' => request()->routeIs(
                                'dashboard',
                            ),
                        ])
                    >
                        Inicio
                    </a>
                </li>
                <li>
                    <a
                        href="{{ route('reportes-generales') }}"
                        @class([
                            'block rounded px-3 py-2 text-slate-200 hover:text-white md:p-0' => ! request()->routeIs('reportes-generales'),
                            'block rounded px-3 py-2 text-white underline underline-offset-8 md:bg-transparent md:p-0' => request()->routeIs(
                                'reportes-generales',
                            ),
                        ])
                    >
                        Reportes
                    </a>
                </li>
                <li>
                    <a
                        href="{{ route('crear-reporte') }}"
                        @class([
                            'block rounded px-3 py-2 text-slate-200 hover:text-white md:p-0' => ! request()->routeIs('crear-reporte'),
                            'block rounded px-3 py-2 text-white underline underline-offset-8 md:bg-transparent md:p-0' => request()->routeIs(
                                'crear-reporte',
                            ),
                        ])
                    >
                        Crear reporte
                    </a>
                </li>
                <li class="relative">
                    <button
                        id="mantenimientos-button"
                        data-dropdown-toggle="mantenimientos-dropdown"
                        class="block rounded px-3 py-2 text-slate-200 hover:text-white md:p-0"
                    >
                        Mantenimientos
                    </button>
                    <div
                        id="mantenimientos-dropdown"
                        class="z-10 hidden w-44 divide-y divide-gray-100 rounded bg-white shadow dark:bg-gray-700"
                    >
                        <ul class="py-1 text-sm text-escarlata-ues" aria-labelledby="mantenimientos-button">
                            <li>
                                <a
                                    href="{{ route('aulas.index') }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                >
                                    Aulas
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
