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
            <x-forms.input-label for="nombre" :value="__('Nombre')" />
            <x-forms.text-input
                id="nombre"
                name="nombre"
                type="text"
                class="mt-1 block w-full"
                :value="old('nombre', $persona->nombre)"
                required
                autofocus
                autocomplete="nombre"
            />
            <x-forms.input-error class="mt-2" :messages="$errors->get('nombre')" />
        </div>

        <!-- Apellidos -->
        <div>
            <x-forms.input-label for="apellido" :value="__('Apellido')" />
            <x-forms.text-input
                id="apellido"
                class="mt-1 block w-full"
                type="text"
                name="apellido"
                :value="old('apellido', $persona->apellido)"
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
                :value="old('fecha_nacimiento', $persona->fecha_nacimiento)"
                placeholder="Seleccionar"
            />
            <x-forms.input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
        </div>

        <!-- No. de teléfono -->
        <div>
            <x-forms.input-label for="telefono" :value="__('Teléfono')" />
            <x-forms.text-input
                id="telefono"
                class="mt-1 block w-full"
                type="text"
                name="telefono"
                :value="old('telefono', $persona->telefono)"
                required
                autofocus
                autocomplete="telefono"
            />
            <x-forms.input-error :messages="$errors->get('telefono')" class="mt-2" />
        </div>

        <!-- Carnet -->
        <div>
            <x-forms.input-label for="username" :value="__('Username')" />
            <x-forms.text-input
                id="carnet"
                class="mt-1 block w-full"
                type="text"
                name="carnet"
                :value="old('carnet', $user->carnet)"
                required
                autofocus
                autocomplete="carnet"
            />
            <x-forms.input-error :messages="$errors->get('carnet')" class="mt-2" />
        </div>

        <div>
            <x-forms.input-label for="email" :value="__('Correo electrónico')" />
            <x-forms.text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                :value="old('email', $user->email)"
                required
                autocomplete="email"
            />
            <x-forms.input-error class="mt-2" :messages="$errors->get('email')" />

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
