@php
    $roleRestricted = [1];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Edición de roles" />
    </x-slot>

    <x-container>
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-forms.row :columns="1">
                <x-forms.field
                    label="Nombre del Rol"
                    name="name"
                    :value="old('name', $role->name)"
                    :error="$errors->get('name')"
                    pattern="^[A-Za-z0-9 ]+$"
                    patternMessage="Solo se permiten letras y numeros en el nombre del rol."
                    required
                />
            </x-forms.row>

            <x-forms.row :fullRow="true">
                <x-picklist.picklist
                    :items="$permissions"
                    :asignados="$role->permissions->pluck('id')->toArray()"
                    tituloDisponibles="Permisos disponibles"
                    tituloAsignados="Permisos asignados"
                    placeholderDisponibles="Buscar permisos..."
                    placeholderAsignados="Buscar permisos asignados..."
                    inputName="permissions"
                />
            </x-forms.row>

            <div class="mt-6 flex justify-center">
                <x-forms.button-group>
                    <x-forms.cancel-button href="{{ route('roles.index') }}">Cancelar</x-forms.cancel-button>
                    @if (! in_array($role->id, $roleRestricted))
                        <x-forms.primary-button class="ml-3">Guardar Cambios</x-forms.primary-button>
                    @endif
                </x-forms.button-group>
            </div>
        </form>
    </x-container>
</x-app-layout>
