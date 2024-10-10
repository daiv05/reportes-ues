<x-app-layout>
    <x-slot name="header">
        <div class="p-6 text-2xl font-bold text-red-900 dark:text-gray-100">
            {{ __('Perfil') }}
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                <div class="max-w-xl">
                    @include('seguridad.profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                <div class="max-w-xl">
                    @include('seguridad.profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-white p-4 shadow dark:bg-gray-800 sm:rounded-lg sm:p-8">
                <div class="max-w-xl">
                    @include('seguridad.profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
