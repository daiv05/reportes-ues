<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Esta es un área restringida de la aplicación. Por favor confirme su contraseña antes de continuar.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-forms.input-label for="password" :value="__('Contraseña')" />

            <x-forms.text-input
                id="password"
                class="mt-1 block w-full"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />

            <x-forms.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4 flex justify-end">
            <x-forms.primary-button>
                {{ __('Confirmar') }}
            </x-forms.primary-button>
        </div>
    </form>
</x-guest-layout>
