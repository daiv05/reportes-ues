<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de usuarios" />
    </x-slot>

    <x-container>
        <!-- Título con el nombre del usuario -->
        <div class="pt-4 pb-8 text-2xl font-bold text-red-900 dark:text-gray-100">
            Usuario : {{ $user->persona->nombre }}
        </div>
        <!-- Formulario para editar usuario -->
        <form action="{{ route('usuarios.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Primera fila: Nombre completo, Correo electrónico y Carnet -->
            <x-forms.row :columns="2">
                <x-forms.field
                    label="Nombre completo"
                    name="nombre"
                    :value="old('nombre', $user->persona->nombre)"
                    type="text"
                    :readonly="true"
                    class="bg-gray-100"
                />

                <x-forms.field
                    label="Correo electrónico"
                    name="email"
                    :value="$user->email"
                    type="email"
                    :readonly="true"
                    class="bg-gray-100"
                />

                <x-forms.field
                    label="Username"
                    name="carnet"
                    :value="$user->carnet"
                    type="text"
                    :readonly="true"
                    class="bg-gray-100"
                />
            </x-forms.row>

            <!-- Estado Activo (Checkbox) -->
            <x-forms.row :fullRow="true">
                <x-forms.checkbox
                    label="Activo"
                    name="activo"
                    :checked="$user->activo"
                />
            </x-forms.row>

            <!-- Picklist de Roles -->
            <x-forms.row :fullRow="true">
                <x-picklist.picklist
                    :items="$roles"
                    :asignados="$user->roles->pluck('id')->toArray()"
                    tituloDisponibles="Roles disponibles"
                    tituloAsignados="Roles asignados"
                    placeholderDisponibles="Buscar roles..."
                    placeholderAsignados="Buscar asignados..."
                    inputName="roles"
                />
            </x-forms.row>

            <!-- Botones para guardar o cancelar -->
            <div class="flex justify-center">
                <x-forms.button-group>
                    <x-forms.cancel-button href="{{ route('usuarios.index') }}">
                        Cancelar
                    </x-forms.cancel-button>

                    <x-forms.primary-button class="ml-3">
                        Guardar Cambios
                    </x-forms.primary-button>
                </x-forms.button-group>
            </div>

        </form>
    </x-container>
</x-app-layout>
