@php
    $headers = [
        ['text' => 'Nombre', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acciones', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    @if (session('message'))
        <x-alert :type="session('message')['type']" :message="session('message')['content']" />
    @endif

    <x-slot name="header">
        <x-header.simple titulo="Gestión de Roles" />
    </x-slot>

    <x-container>
        <x-forms.primary-button data-modal-target="static-modal" data-modal-toggle="static-modal" type="button"
            id="add-button" class="mb-6">
            Añadir
        </x-forms.primary-button>

        <x-table.base :headers="$headers">
            @foreach ($roles as $rol)
                <x-table.tr>
                    <x-table.td>{{ $rol->name }}</x-table.td>
                    <x-table.td><x-status.is-active :active="$rol->activo" /></x-table.td>
                    <x-table.td>
                        <a href="#" class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                            data-id="{{ $rol->id }}" data-name="{{ $rol->name }}" data-activo="{{ $rol->activo }}">
                            <x-heroicon-o-pencil class="h-5 w-5" />
                        </a>
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.base>

        <nav class="flex flex-wrap items-center justify-center pt-4" aria-label="Table navigation">
            {{ $roles->links() }}
        </nav>

        <!-- Modal para Añadir/Editar Rol -->
        <x-form-modal id="static-modal">
            <x-slot name="header">
                <h3 id="head-text" class="text-2xl font-bold text-escarlata-ues">Añadir Rol</h3>
            </x-slot>
            <x-slot name="body">
                <form id="add-roles-form" method="POST" action="{{ route('roles.store') }}">
                    @csrf
                    <x-forms.row :fullRow="true">
                        <x-forms.field label="Nombre" name="name" type="text" :value="old('name')" :error="$errors->get('name')" />
                    </x-forms.row>
                    <x-forms.row :fullRow="true">
                        <x-forms.select label="Estado" name="activo" :options="['1' => 'ACTIVO', '0' => 'INACTIVO']" :selected="old('activo')" :error="$errors->get('activo')" />
                    </x-forms.row>
                </form>
            </x-slot>
            <x-slot name="footer">
                <x-forms.button-group>
                    <x-forms.cancel-button data-modal-hide="static-modal">
                        Cancelar
                    </x-forms.cancel-button>

                    <x-forms.primary-button type="submit" form="add-roles-form" class="ms-6">
                        Guardar
                    </x-forms.primary-button>
                </x-forms.button-group>
            </x-slot>
        </x-form-modal>
    </x-container>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const formModal = document.getElementById('static-modal');
    const addButton = document.getElementById('add-button');
    const addRolesForm = document.getElementById('add-roles-form');
    const modalHeaderText = document.getElementById('head-text');
    const nameField = document.getElementById('name');
    const activoField = document.getElementById('activo');

    // Función para limpiar el formulario
    function resetForm() {
        addRolesForm.reset();
        document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
        addRolesForm.removeAttribute('method');
        addRolesForm.action = '{{ route('roles.store') }}'; // Acción para crear un nuevo rol

        // Eliminar el campo oculto _method si existe
        const hiddenMethodField = addRolesForm.querySelector('input[name="_method"]');
        if (hiddenMethodField) {
            hiddenMethodField.remove();
        }
    }

    // Evento para abrir el modal en modo "Agregar Rol"
    addButton.addEventListener('click', function () {
        resetForm();
        modalHeaderText.textContent = 'Agregar Rol';
        formModal.style.display = 'block'; // Abre el modal
    });

    // Evento para abrir el modal en modo "Editar Rol"
    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const activo = this.getAttribute('data-activo');

            // Resetear el formulario antes de cargar los datos para edición
            resetForm();

            // Configurar el formulario para editar el rol
            addRolesForm.action = `/seguridad/roles/${id}`; // Acción para actualizar el rol
            addRolesForm.method = 'POST';

            // Añadir el campo _method para indicar que es una actualización (PUT)
            const methodInput = document.createElement('input');
            methodInput.setAttribute('type', 'hidden');
            methodInput.setAttribute('name', '_method');
            methodInput.setAttribute('value', 'PUT');
            addRolesForm.appendChild(methodInput);

            // Rellenar los campos con los datos del rol
            nameField.value = name;
            activoField.value = activo;
            modalHeaderText.textContent = 'Editar Rol';

            // Mostrar el modal
            formModal.style.display = 'block'; // Abre el modal
        });
    });

    // Evento para cerrar el modal y limpiar el formulario
    document.querySelectorAll('[data-modal-hide="static-modal"]').forEach((button) => {
        button.addEventListener('click', function () {
            resetForm();
            formModal.style.display = 'none'; // Cierra el modal
        });
    });
});
</script>

