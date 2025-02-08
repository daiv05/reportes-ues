<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="flex flex-col space-y-3">
        @csrf

        <!-- Nombres -->
        <div>
            <x-forms.field
                label="Nombre"
                name="nombre"
                pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ]{1,100}$"
                patternMessage="Solo se permiten 100 caracteres que sean letras o espacios"
                :value="old('nombre')"
                :error="$errors->get('nombre')"
                required
            />
        </div>

        <!-- Apellidos -->
        <div>
            <x-forms.field
                label="Apellido"
                name="apellido"
                pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ]{1,100}$"
                patternMessage="Solo se permiten 100 caracteres que sean letras o espacios"
                :value="old('apellido')"
                :error="$errors->get('apellido')"
                required
            />
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
            <x-forms.select
                label="Escuela"
                name="escuela"
                :options="$escuelas->pluck('nombre', 'id')"
                :selected="old('escuela')"
                :error="$errors->get('escuela')"
                required
            />
        </div>

        <!-- No. de teléfono -->
        <div>
            <x-forms.field
                label="Teléfono"
                name="telefono"
                pattern="^\+?(\d{1,4})?[-.\s]?(\(?\d{2,4}\)?)?[-.\s]?\d{3,4}[-.\s]?\d{4}$"
                patternMessage="El número de teléfono debe tener un formato válido"
                :value="old('telefono')"
                :error="$errors->get('telefono')"
            />
        </div>

        <!-- Carnet -->
        <div>
            <x-forms.field
                label="Usuario/Carnet"
                name="carnet"
                pattern="^(?!.*[._])?[a-zA-Z0-9](?:[a-zA-Z0-9._]{2,18}[a-zA-Z0-9])?$"
                patternMessage="El carnet debe tener entre 3 y 20 caracteres y solo puede contener letras, números, puntos y guiones bajos"
                :value="old('carnet')"
                :error="$errors->get('carnet')"
                required
            />
        </div>

        <!-- Email Address -->
        <div>
            <x-forms.field
                label="Correo electrónico"
                type="email"
                name="email"
                :value="old('email')"
                :error="$errors->get('email')"
                required
            />
        </div>

        <!-- Password -->
        <div>
            <x-forms.field
                label="Contraseña"
                type="password"
                name="password"
                :value="old('password')"
                :error="$errors->get('password')"
                required
            />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-forms.field
                label="Confirmar contraseña"
                type="password"
                name="password_confirmation"
                :value="old('password_confirmation')"
                :error="$errors->get('password_confirmation')"
                required
            />
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
        <a class="rounded-md text-sm text-gray-600 underline hover:text-gray-900" href="{{ route('landing') }}">
            <x-heroicon-s-arrow-left class="h-4 w-4" />
        </a>
    </form>
</x-guest-layout>
