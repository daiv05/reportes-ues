<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-2">
        @csrf

        <!-- Nombres -->
        <div>
            <x-forms.input-label for="nombre" :value="__('Nombre')" />
            <x-forms.text-input
                id="nombre"
                class="mt-1 block w-full"
                type="text"
                name="nombre"
                :value="old('nombre')"
                required
                autofocus
                autocomplete="nombre"
            />
            <x-forms.input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <!-- Apellidos -->
        <div>
            <x-forms.input-label for="apellido" :value="__('Apellido')" />
            <x-forms.text-input
                id="apellido"
                class="mt-1 block w-full"
                type="text"
                name="apellido"
                :value="old('apellido')"
                required
                autofocus
                autocomplete="apellido"
            />
            <x-forms.input-error :messages="$errors->get('apellido')" class="mt-2" />
        </div>

        <!-- Fecha de nacimiento -->
        <div>
            <x-forms.input-label for="fecha_nacimiento" :value="__('Fecha de nacimiento')" />
            <x-forms.date-input
                name="fecha_nacimiento"
                :value="old('fecha_nacimiento')"
                placeholder="Seleccione una fecha"
            />
            <x-forms.input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
        </div>

        <!-- Escuela -->
        <div>
            <x-forms.input-label for="escuela" :value="__('Escuela')" />
            <select
                id="escuela"
                class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                name="escuela"
                required
                autofocus
                autocomplete="escuela"
            >
                @foreach($escuelas as $escuela)
                    <option value="{{ $escuela->id }}">{{ $escuela->nombre }}</option>
                @endforeach
            </select>
            <x-forms.input-error :messages="$errors->get('escuela')" class="mt-2" />
        </div>

        <!-- No. de teléfono -->
        <div>
            <x-forms.input-label for="telefono" :value="__('Teléfono')" />
            <x-forms.text-input
                id="telefono"
                class="mt-1 block w-full"
                type="text"
                name="telefono"
                :value="old('telefono')"
                required
                autofocus
                autocomplete="telefono"
            />
            <x-forms.input-error :messages="$errors->get('telefono')" class="mt-2" />
        </div>

        <!-- Carnet -->
        <div>
            <x-forms.input-label for="carnet" :value="__('Carnet')" />
            <x-forms.text-input
                id="carnet"
                class="mt-1 block w-full"
                type="text"
                name="carnet"
                :value="old('carnet')"
                required
                autofocus
                autocomplete="carnet"
            />
            <x-forms.input-error :messages="$errors->get('carnet')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-forms.input-label for="email" :value="__('Correo electrónico')" />
            <x-forms.text-input
                id="email"
                class="mt-1 block w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />
            <x-forms.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-forms.input-label for="password" :value="__('Contraseña')" />

            <x-forms.text-input
                id="password"
                class="mt-1 block w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />

            <x-forms.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-forms.input-label for="password_confirmation" :value="__('Confirmar contraseña')" />

            <x-forms.text-input
                id="password_confirmation"
                class="mt-1 block w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />

            <x-forms.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-4 flex items-center justify-end">
            <a
                class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}"
            >
                {{ __('¿Ya tienes una cuenta?') }}
            </a>

            <x-forms.primary-button class="ms-4">
                {{ __('Registrarse') }}
            </x-forms.primary-button>
        </div>
    </form>
</x-guest-layout>
