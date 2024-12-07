@php
    $headers = [
        ['text' => 'Nombre', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'left'],
        ['text' => 'Acción', 'align' => 'left'],
    ];
@endphp
<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de Unidades de Medida" />
        <div class="p-6">
            <x-forms.primary-button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block"
                type="button">
                Añadir
            </x-forms.primary-button>
        </div>
    </x-slot>

    <x-container>
        <x-table.base :headers="$headers">
            @foreach ($unidades as $unidad)
                <x-table.tr>
                    <x-table.td>
                        {{ $unidad->nombre }}
                    </x-table.td>
                    <x-table.td>
                        <x-status.is-active :active="$unidad->activo" />
                    </x-table.td>
                    <x-table.td>
                        <a href="#"
                            class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                            data-id="{{ $unidad->id }}" data-nombre="{{ $unidad->nombre }}" data-activo="{{ $unidad->activo }}">
                            <x-heroicon-o-pencil class="h-5 w-5" />
                        </a>
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.base>

        <nav class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row"
            aria-label="Table navigation">
            {{ $unidades->links() }}
        </nav>
    </x-container>

    <!-- Modal para añadir o editar una unidad de medida -->
    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 id="modal-title" class="text-2xl font-bold text-escarlata-ues">Añadir Unidad de Medida</h3>
        </x-slot>

        <x-slot name="body">
            <form id="unidad-form" method="POST" action="{{ route('unidades-medida.store') }}">
                @csrf
                <div id="general-errors" class="mb-4 text-sm text-red-500"></div>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.field id="nombre" label="Nombre" name="nombre" :value="old('nombre')" :error="$errors->get('nombre')" required />
                        <div id="nombre-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="1">
                    <x-forms.select label="Estado" id="activo" name="activo" :options="['1' => 'ACTIVO', '0' => 'INACTIVO']"
                        :value="old('activo', '1')" :error="$errors->get('activo')" required />
                    <div id="estado-error" class="text-sm text-red-500"></div>
                </x-forms.row>
            </form>
        </x-slot>

        <x-slot name="footer">
            <button data-modal-hide="static-modal" type="button"
                class="rounded-lg border bg-gray-700 px-7 py-2.5 text-sm font-medium text-white focus:z-10 focus:outline-none focus:ring-4">
                Cancelar
            </button>
            <button type="submit" form="unidad-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>

<script>
    document.getElementById('unidad-form').addEventListener('submit', function(event) {
        const nombreField = document.getElementById('nombre');
        const estadoField = document.getElementById('activo');

        let hasErrors = false;

        document.getElementById('general-errors').innerHTML = '';
        document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));

        if (!nombreField.value.trim()) {
            hasErrors = true;
            document.getElementById('nombre-error').innerHTML = 'El campo Nombre es obligatorio';
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
            updateModalTitle('Añadir Unidad de Medida');

            resetForm();

            document.getElementById('unidad-form').method = 'POST';
            document.getElementById('unidad-form').action = "{{ route('unidades-medida.store') }}";

            document.querySelectorAll('input[name="_method"]').forEach((input) => input.remove());
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const activo = this.getAttribute('data-activo');

            updateModalTitle('Editar Unidad de Medida');

            document.getElementById('unidad-form').action = `/mantenimientos/unidades-medida/${id}`;
            document.getElementById('unidad-form').method = 'POST';

            if (!document.querySelector('input[name="_method"]')) {
                document.getElementById('unidad-form').innerHTML +=
                    '<input type="hidden" name="_method" value="PUT">';
            }

            document.getElementById('nombre').value = nombre;
            document.getElementById('activo').value = activo;

            // Abrir el modal
            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });

    function updateModalTitle(title) {
        document.getElementById('modal-title').textContent = title;
    }

    function resetForm() {
        document.getElementById('unidad-form').reset();
        document.getElementById('general-errors').innerHTML = '';
        document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
    }
</script>