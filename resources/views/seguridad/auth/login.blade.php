<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Carnet -->
        <div>
            <x-forms.input-label for="username" :value="__('Username')" />
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

        <!-- Password -->
        <div class="mt-4">
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

        <!-- Remember Me -->
        <div class="mt-4 block">
            <label for="remember_me" class="inline-flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember"
                />
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Recordarme') }}</span>
            </label>
        </div>

        <div class="mt-4 flex items-center justify-end">
            @if (Route::has('password.request'))
                <a
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}"
                >
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif

            <x-forms.primary-button class="ms-3">
                {{ __('Iniciar sesión') }}
            </x-forms.primary-button>
        </div>
    </form>
</x-guest-layout>
