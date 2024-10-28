<x-app-layout>
    @if (session('message'))
        <x-alert :type="session('message')['type']" :message="session('message')['content']" />
    @endif

    <x-slot name="header">
        <x-header.simple titulo="Gestión de usuarios" />
    </x-slot>

    <x-container>
        <!-- Título con el nombre del usuario -->
        <x-header.simple titulo="Usuario : {{ $user->persona->nombre }}" />

        <!-- Formulario para editar usuario -->
        <form action="{{ route('usuarios.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Primera fila: Nombre completo, Correo electrónico y Carnet -->
            <x-forms.row :columns="2">
                <x-forms.field
                    label="Nombre completo"
                    name="nombre"
                    :value="$user->persona->nombre"
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
                    label="Carnet"
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
