<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nombres -->
        <div>
            <x-input-label for="nombre" :value="__('Nombre')" />
            <x-text-input
                id="nombre"
                class="mt-1 block w-full"
                type="text"
                name="nombre"
                :value="old('nombre')"
                required
                autofocus
                autocomplete="nombre"
            />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Apellidos -->
        <div>
            <x-input-label for="apellido" :value="__('Apellido')" />
            <x-text-input
                id="apellido"
                class="mt-1 block w-full"
                type="text"
                name="apellido"
                :value="old('apellido')"
                required
                autofocus
                autocomplete="apellido"
            />
            <x-input-error :messages="$errors->get('apellido')" class="mt-2" />
        </div>

        <!-- Fecha de nacimiento -->
        <div>
            <x-input-label for="fecha_nacimiento" :value="__('Fecha de nacimiento')" />
            <x-date-input name="fecha_nacimiento" :value="old('fecha_nacimiento')" placeholder="Seleccione una fecha" />
            <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
        </div>

        <!-- No. de teléfono -->
        <div>
            <x-input-label for="telefono" :value="__('Teléfono')" />
            <x-text-input
                id="telefono"
                class="mt-1 block w-full"
                type="text"
                name="telefono"
                :value="old('telefono')"
                required
                autofocus
                autocomplete="telefono"
            />
            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
        </div>

        <!-- Carnet -->
        <div>
            <x-input-label for="carnet" :value="__('Carnet')" />
            <x-text-input
                id="carnet"
                class="mt-1 block w-full"
                type="text"
                name="carnet"
                :value="old('carnet')"
                required
                autofocus
                autocomplete="carnet"
            />
            <x-input-error :messages="$errors->get('carnet')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input
                id="email"
                class="mt-1 block w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input
                id="password"
                class="mt-1 block w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />

            <x-text-input
                id="password_confirmation"
                class="mt-1 block w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4 flex items-center justify-end">
            <a
                class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}"
            >
                {{ __('¿Ya tienes una cuenta?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
