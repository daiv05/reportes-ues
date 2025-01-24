<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Información de perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Actualice la información de su perfil.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Nombres -->
        <div>
            <x-forms.field
                label="Nombre"
                name="nombre"
                pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ]{1,100}$"
                patternMessage="Solo se permiten 100 caracteres que sean letras o espacios"
                :value="old('nombre', $persona->nombre)"
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
                :value="old('apellido', $persona->apellido)"
                :error="$errors->get('apellido')"
                required
            />
        </div>

        <!-- Fecha de nacimiento -->
        <div>
            <x-forms.input-label for="fecha_nacimiento" :value="__('Fecha de nacimiento')" />
            <x-forms.date-input
                name="fecha_nacimiento"
                :value="old('fecha_nacimiento', $persona->fecha_nacimiento)"
                placeholder="Seleccionar"
            />
            <x-forms.input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
        </div>

        <!-- No. de teléfono -->
        <div>
            <x-forms.field
                label="Teléfono"
                name="telefono"
                pattern="^\+?(\d{1,4})?[-.\s]?(\(?\d{2,4}\)?)?[-.\s]?\d{3,4}[-.\s]?\d{4}$"
                patternMessage="El número de teléfono debe tener un formato válido"
                :value="old('telefono', $persona->telefono)"
                :error="$errors->get('telefono')"
                required
            />
        </div>

        <!-- Carnet -->
        <div>
            <x-forms.field
                label="Usuario/Carnet"
                name="carnet"
                pattern="^(?!.*[._])?[a-zA-Z0-9](?:[a-zA-Z0-9._]{2,18}[a-zA-Z0-9])?$"
                patternMessage="El carnet debe tener entre 3 y 20 caracteres y solo puede contener letras, números, puntos y guiones bajos"
                :value="old('carnet', $user->carnet)"
                :error="$errors->get('carnet')"
                required
            />
        </div>

        <div>
            <x-forms.field
                label="Correo electrónico"
                name="email"
                type="email"
                :value="old('email', $user->email)"
                :error="$errors->get('email')"
                required
            />
        </div>

        <div class="flex items-center gap-4">
            <x-forms.primary-button>{{ __('Guardar') }}</x-forms.primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => (show = false), 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >
                    {{ __('Guardado.') }}
                </p>
            @endif
        </div>
    </form>
</section>
