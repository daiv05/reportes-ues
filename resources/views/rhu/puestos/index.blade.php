@php
    $headers = [
        ['text' => 'Puesto', 'align' => 'left'],
        ['text' => 'Entidad', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acciones', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de Puestos" />
        <div class="p-6">
            <x-forms.primary-button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block"
                type="button">
                Añadir
            </x-forms.primary-button>
        </div>
    </x-slot>
    <x-container>
        <x-table.base :headers="$headers">
            @foreach ($puestos as $puesto)
                <x-table.tr>
                    <x-table.td>
                        {{ $puesto->nombre }}
                    </x-table.td>
                    <x-table.td>
                        {{ $puesto->entidad->nombre }}
                    </x-table.td>
                    <x-table.td>
                        <x-status.is-active :active="$puesto->activo" />
                    </x-table.td>
                    <x-table.td>
                        <a href="#"
                            class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                            data-id="{{ $puesto->id }}" data-nombre="{{ $puesto->nombre }}"
                            data-entidad="{{ $puesto->id_entidad }}" data-activo="{{ $puesto->activo }}">
                            <x-heroicon-o-pencil class="h-5 w-5" />
                        </a>
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.base>
        <nav class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row"
            aria-label="Table navigation">
            {{ $puestos->links() }}
        </nav>

    </x-container>

    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 id="modal-title" class="text-2xl font-bold text-escarlata-ues">Añadir Puesto</h3>
        </x-slot>
        <x-slot name="body">
            <form id="asignacion-form" method="POST" action="{{ route('puestos.store') }}">
                @csrf
                <div id="general-errors" class="mb-4 text-sm text-red-500"></div>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.select label="Entidad" id="id_entidad" name="id_entidad" :options="$entidades->pluck('nombre', 'id')->toArray()"
                            :value="old('id_entidad')" :error="$errors->get('id_entidad')" />
                        <div id="entidad-error" class="text-sm text-red-500"></div>
                    </div>
                    <div>
                        <x-forms.field id="nombre" label="Nombre" name="nombre" :value="old('nombre')"
                            :error="$errors->get('nombre')" />
                        <div id="nombre-error" class="text-sm text-red-500"></div>
                    </div>

                    <div>
                        <x-forms.select label="Estado" id="activo" name="activo" :options="['1' => 'ACTIVO', '0' => 'INACTIVO']" :value="old('activo', '1')"
                            :error="$errors->get('activo')" />
                        <div id="estado-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
            </form>
        </x-slot>
        <x-slot name="footer">
            <button data-modal-hide="static-modal" type="button"
                class="rounded-lg border bg-gray-700 px-7 py-2.5 text-sm font-medium text-white focus:z-10 focus:outline-none focus:ring-4">
                Cancelar
            </button>
            <button type="submit" form="asignacion-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>
<script>
    document.getElementById('asignacion-form').addEventListener('submit', function(event) {
        const nombreField = document.getElementById('nombre');
        const entidadField = document.getElementById('id_entidad');
        const estadoField = document.getElementById('activo');

        let hasErrors = false;

        document.getElementById('general-errors').innerHTML = '';
        document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));

        if (!nombreField.value.trim()) {
            hasErrors = true;
            document.getElementById('nombre-error').innerHTML = 'El campo Nombre es obligatorio';
        }

        if (!entidadField.value.trim()) {
            hasErrors = true;
            document.getElementById('entidad-error').innerHTML = 'El campo entidad es obligatorio';
        }

        if (!estadoField.value.trim()) {
            hasErrors = true;
            document.getElementById('estado-error').innerHTML = 'El campo Estado es obligatorio';
        }

        if (hasErrors) {
            event.preventDefault();
            document.getElementById('general-errors').innerHTML = 'Todos los campos son requeridos';
        }
    });

    document.querySelectorAll('[data-modal-hide="static-modal"]').forEach((button) => {
        button.addEventListener('click', function() {
            updateModalTitle('Añadir Aula');

            resetForm();

            document.getElementById('asignacion-form').method = 'POST';
            document.getElementById('asignacion-form').action = "{{ route('puestos.store') }}";

            document.querySelectorAll('input[name="_method"]').forEach((input) => input.remove());

        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const entidad = this.getAttribute('data-entidad');
            const activo = this.getAttribute('data-activo');

            updateModalTitle('Editar Aula');

            document.getElementById('asignacion-form').action = `/rhu/puestos/${id}`;
            document.getElementById('asignacion-form').method = 'POST';

            if (!document.querySelector('input[name="_method"]')) {
                document.getElementById('asignacion-form').innerHTML +=
                    '<input type="hidden" name="_method" value="PUT">';
            }

            document.getElementById('nombre').value = nombre;
            document.getElementById('id_entidad').value = entidad;
            document.getElementById('activo').value = activo;

            // Abrir el modal
            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });


    function updateModalTitle(title) {
        document.getElementById('modal-title').textContent = title;
    }
    // Función para resetear el formulario y limpiar los errores
    function resetForm() {
        document.getElementById('asignacion-form').reset(); // Limpiar el formulario
        document.getElementById('general-errors').innerHTML = ''; // Limpiar errores generales

        document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML =
            '')); // Limpiar errores específicos de campo

        // Limpiar los valores de los select
        document.querySelectorAll('select').forEach((select) => {
            select.selectedIndex = 0; // Restablecer el primer valor (vacío o predeterminado)
        });
    }
</script>
