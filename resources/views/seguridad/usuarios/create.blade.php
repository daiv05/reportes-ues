<x-app-layout>
    @if (session('message'))
        <x-alert :type="session('message')['type']" :message="session('message')['content']" />
    @endif
    <x-slot name="header">
        <x-header.simple titulo="Gestión de usuarios" />
    </x-slot>

    <x-container>
        <form action="{{ route('usuarios.store') }}" method="POST">
            @csrf
            <x-forms.row :fullRow="true">
                <x-forms.select label="Seleccionar Persona" name="persona_id" :options="$personasSinUsuario->pluck('nombre', 'id')->toArray()" :selected="old('persona_id')"
                    :error="$errors->get('persona_id')" />
            </x-forms.row>
            <x-forms.row :columns="2">
                <x-forms.field label="Correo electrónico" name="email" type="email" :value="old('email')"
                    :error="$errors->get('email')" />
                <x-forms.field label="Carnet / Nombre de usuario" name="carnet" :value="old('carnet')" :error="$errors->get('carnet')" />
                <x-forms.checkbox label="Activo" name="activo" :checked="old('activo')" :error="$errors->get('activo')" />
            </x-forms.row>
            <x-forms.row :fullRow="true">
                <x-picklist.picklist :items="$roles" :asignados="[]" tituloDisponibles="Roles disponibles"
                    tituloAsignados="Roles asignados" placeholderDisponibles="Buscar roles..."
                    placeholderAsignados="Buscar roles asignados..." inputName="roles" />
            </x-forms.row>
            <x-forms.button-group>
                <x-forms.cancel-button href="{{ route('usuarios.index') }}">
                    Cancelar
                </x-forms.cancel-button>

                <x-forms.primary-button class="ml-3">
                    Guardar Cambios
                </x-forms.primary-button>
            </x-forms.button-group>

        </form>
    </x-container>
</x-app-layout>
