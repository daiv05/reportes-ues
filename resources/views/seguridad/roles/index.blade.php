@php
    $headers = [
        ['text' => 'Nombre', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acción', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de Roles" />
    </x-slot>

    <div>
        <div class="p-6">
            <x-forms.primary-button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block"
                type="button" id="add-button">
                Añadir Rol
            </x-forms.primary-button>
        </div>
        <div class="mx-auto mb-8">
            <x-table.base :headers="$headers">
                @foreach ($roles as $rol)
                    <x-table.tr>
                        <x-table.td>
                            {{ $rol->name }}
                        </x-table.td>
                        <x-table.td justify="center">
                            <x-status.is-active :active="$rol->activo" />
                        </x-table.td>
                        <x-table.td>
                            <a href="#"
                                class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                data-id="{{ $rol->id }}" data-name="{{ $rol->name }}"
                                data-activo="{{ $rol->activo }}">
                                <x-heroicon-o-pencil class="h-5 w-5" />
                            </a>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.base>
            <nav class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row"
                aria-label="Table navigation">
                {{ $roles->links() }}
            </nav>
        </div>
    </div>

    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 id="modal-title" class="text-2xl font-bold text-escarlata-ues">Añadir Rol</h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-role-form" method="POST" action="{{ route('roles.store') }}">
                @csrf
                <div id="general-errors" class="mb-4 text-sm text-red-500"></div>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.field id="name" label="Nombre" name="name" type="text" :value="old('nombre')" />
                        <div id="name-error" class="text-sm text-red-500"></div>
                    </div>
                    <div>
                        <x-forms.select label="Estado" id="activo" name="activo" :options="['1' => 'ACTIVO', '0' => 'INACTIVO']" :value="old('activo', '1')" />
                        <div id="activo-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
            </form>
        </x-slot>
        <x-slot name="footer">
            <button data-modal-hide="static-modal" type="button"
                class="rounded-lg border bg-gray-700 px-7 py-2.5 text-sm font-medium text-white focus:z-10 focus:outline-none focus:ring-4">
                Cancelar
            </button>
            <button type="submit" form="add-role-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
    </x-app-layout>

    <script>
        // Validación del formulario
        document.getElementById('add-role-form').addEventListener('submit', function(event) {
            const nameField = document.getElementById('name');
            const activeField = document.getElementById('activo');

            let hasErrors = false;

            // Limpiar mensajes de error previos
            document.getElementById('general-errors').innerHTML = '';
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));

            // Validar campo Nombre
            if (!nameField.value.trim()) {
                hasErrors = true;
                document.getElementById('name-error').innerHTML = 'El campo Nombre es obligatorio';
            }

            // Validar campo Estado
            if (!activeField.value.trim()) {
                hasErrors = true;
                document.getElementById('activo-error').innerHTML = 'El campo Estado es obligatorio';
            }

            // Prevenir envío si hay errores
            if (hasErrors) {
                event.preventDefault();
                document.getElementById('general-errors').innerHTML = 'Todos los campos son requeridos';
            }
        });

        // Resetear el formulario y limpiar errores al cerrar el modal
        document.querySelectorAll('[data-modal-hide="static-modal"]').forEach((button) => {
            button.addEventListener('click', function() {
                updateModalTitle('Añadir Rol');
                document.getElementById('add-role-form').reset();
                document.getElementById('general-errors').innerHTML = '';
                document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
            });
        });

        // Configuración del formulario al editar
        document.querySelectorAll('.edit-button').forEach((button) => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const activo = this.getAttribute('data-activo');

                updateModalTitle('Editar Rol');

                document.getElementById('add-role-form').action = `/seguridad/roles/${id}`;
                document.getElementById('add-role-form').method = 'POST';
                document.getElementById('add-role-form').innerHTML +=
                    '<input type="hidden" name="_method" value="PUT">';

                // Rellenar campos con los valores actuales
                document.getElementById('name').value = name;
                document.getElementById('activo').value = activo;

                // Abrir el modal
                document.querySelector('[data-modal-target="static-modal"]').click();
            });
        });

        // Actualizar el título del modal dinámicamente
        function updateModalTitle(title) {
            document.getElementById('modal-title').textContent = title;
        }
    </script>

