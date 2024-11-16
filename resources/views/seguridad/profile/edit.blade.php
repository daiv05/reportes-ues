<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Perfil" />
    </x-slot>

    <div>
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
    </div>
</x-app-layout>
