<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Información de perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Actualice la información de su perfil.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

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
            <x-date-input
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
            <x-forms.input-label for="carnet" :value="__('Carnet')" />
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

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-sm text-gray-800 dark:text-gray-200">
                        {{ __('Tu correo electrónico no está verificado.') }}

                        <button
                            form="send-verification"
                            class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                        >
                            {{ __('Haga clic aquí para volver a enviar el correo electrónico de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
                            {{ __('Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
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
