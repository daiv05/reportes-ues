<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de usuarios" />
    </x-slot>

    <x-container>
        <form action="{{ route('usuarios.store') }}" method="POST">
            @csrf
            <x-forms.row :columns="2">
                <x-forms.field label="Nombre" name="nombre" :value="old('nombre')" :error="$errors->get('nombre')" />
                <x-forms.field label="Apellido" name="apellido" :value="old('apellido')" :error="$errors->get('apellido')" />
            </x-forms.row>
            <x-forms.row :columns="2">
                <div>
                    <x-forms.input-label for="fecha_nacimiento" :value="__('Fecha de nacimiento')" />
                    <x-forms.date-input
                        name="fecha_nacimiento"
                        :value="old('fecha_nacimiento')"
                        placeholder="Seleccione una fecha"
                    />
                    <x-forms.input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
                </div>
                <x-forms.field label="Teléfono" name="telefono" :value="old('telefono')" :error="$errors->get('telefono')" />
            </x-forms.row>
            <x-forms.row :columns="2">
                <x-forms.field label="Correo electrónico" name="email" type="email" :value="old('email')"
                    :error="$errors->get('email')" />
                <x-forms.field label="Carnet / Nombre de usuario" name="carnet" :value="old('carnet')" :error="$errors->get('carnet')" />
            </x-forms.row>
            <x-forms.row :columns="1">
                <x-forms.checkbox label="Activo" name="activo" :checked="old('activo')" :error="$errors->get('activo')" />
            </x-forms.row>
            <x-forms.row :columns="2">
                <x-forms.select label="Entidad" name="entidad" :options="$entidades" :value="old('entidad')" onchange="filtrarPuestos()" />
                <x-forms.select label="Puesto" id="puesto" name="puesto" :options="$puestos[old('entidad')] ?? []" :value="old('puesto')" :error="$errors->get('puesto')" />
            </x-forms.row>
            <x-forms.row :fullRow="true">
                <x-picklist.picklist :items="$roles" :asignados="[]" tituloDisponibles="Roles disponibles"
                    tituloAsignados="Roles asignados" placeholderDisponibles="Buscar roles..."
                    placeholderAsignados="Buscar roles asignados..." inputName="roles" />
            </x-forms.row>
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
    <script>
        const puestosPorEntidad = @json($puestos);

        function filtrarPuestos() {
            const entidadId = document.querySelector('[name="entidad"]').value;
            console.log(entidadId);
            const puestoSelect = document.querySelector('[name="puesto"]');

            // Limpiar el campo de puestos
            puestoSelect.innerHTML = '<option value="">Seleccionar Puesto</option>';

            if (entidadId && puestosPorEntidad[entidadId]) {
                // Agregar puestos filtrados al select
                Object.entries(puestosPorEntidad[entidadId]).forEach(([id, nombre]) => {
                    const option = document.createElement('option');
                    option.value = id;
                    option.textContent = nombre;
                    puestoSelect.appendChild(option);
                });
            }
        }
    </script>
</x-app-layout>
