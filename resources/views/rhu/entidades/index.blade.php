@php
    $headers = [
        ['text' => 'Nombre', 'align' => 'left'],
        ['text' => 'Descripción', 'align' => 'left'],
        ['text' => 'Entidad Padre', 'align' => 'left'], // Nueva columna
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acciones', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de Entidades" />
    </x-slot>

    <div>
        <div class="p-6">
            <x-forms.primary-button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block"
                type="button" id="add-button">
                Añadir
            </x-forms.primary-button>
        </div>
        <x-table.base :headers="$headers">
            @foreach ($entidades as $entidad)
                <x-table.tr>
                    <x-table.td>
                        {{ $entidad->nombre }}
                    </x-table.td>
                    <x-table.td>
                        {{ $entidad->descripcion }}
                    </x-table.td>
                    <x-table.td>
                        {{-- Mostrar el entidad padre o "Raíz" si es null --}}
                        {{ $entidad->id_entidad ? $entidad->padre->nombre : '-' }}
                    </x-table.td>
                    <x-table.td>
                        <x-status.is-active :active="$entidad->activo" />
                    </x-table.td>
                    <x-table.td>
                        <a href="#"
                            class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                            data-id="{{ $entidad->id }}" data-nombre="{{ $entidad->nombre }}"
                            data-descripcion="{{ $entidad->descripcion }}" data-activo="{{ $entidad->activo }}"
                            data-id_entidad="{{ $entidad->id_entidad }}">
                            <x-heroicon-o-pencil class="h-5 w-5" />
                        </a>
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.base>
        <nav class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row"
            aria-label="Table navigation">
            {{ $entidades->links() }}
        </nav>
    </div>


    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 id="head-text" class="text-2xl font-bold text-escarlata-ues">Añadir entidad</h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-entidades-form" method="POST" action="{{ route('entidades.store') }}">
                @csrf
                <x-forms.row :columns="1">
                    <x-forms.field label="Nombre" name="nombre" type="text" :value="old('nombre')" :error="$errors->get('nombre')" />
                    <div>
                        <x-forms.input-label for="descripcion" :value="__('Descripcion')" />
                        <textarea id="descripcion" name="descripcion" rows="4"
                            class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                            placeholder="Describa brevemente las funciones..."></textarea>
                        <x-forms.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                    </div>
                    <x-forms.select label="Entidad Padre" id="id_entidad" name="id_entidad" :options="['' => 'Ninguno (Raíz)'] + $entidadesLista->pluck('nombre', 'id')->toArray()"
                        :value="old('id_entidad')" :error="$errors->get('id_entidad')" />
                    <x-forms.select label="Estado" id="activo" name="activo" :options="['1' => 'ACTIVO', '0' => 'INACTIVO']" :value="old('activo', '1')"
                        :error="$errors->get('activo')" />
                </x-forms.row>
            </form>
        </x-slot>
        <x-slot name="footer">
            <button data-modal-hide="static-modal" type="button"
                class="rounded-lg border bg-gray-700 px-7 py-2.5 text-sm font-medium text-white focus:z-10 focus:outline-none focus:ring-4">
                Cancelar
            </button>
            <button type="submit" form="add-entidades-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>
<script>
    document.getElementById('add-entidades-form').addEventListener('submit', function(event) {
        let hasErrors = false;
        let errorMessage = '';

        const nombre = document.getElementById('nombre').value.trim();
        if (nombre === '') {
            hasErrors = true;
            errorMessage += 'El campo Nombre es obligatorio<br>';
        } else if (nombre.length > 50) {
            hasErrors = true;
            errorMessage += 'El campo Nombre no debe exceder los 50 caracteres<br>';
        }

        if (descripcion === '') {
            hasErrors = true;
            errorMessage += 'El campo Descripción es obligatorio<br>';
        } else if (descripcion.length > 100) {
            hasErrors = true;
            errorMessage += 'El campo Descripción no debe exceder los 100 caracteres<br>';
        }

        if (hasErrors) {
            event.preventDefault();
            document.getElementById('general-errors').innerHTML = errorMessage;
        }
    });

    document.querySelectorAll('[data-modal-hide="static-modal"]').forEach((button) => {
        button.addEventListener('click', function() {
            document.getElementById('add-entidades-form').reset();
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
        });
    });

    document.getElementById('add-button').addEventListener('click', function(event) {
        // Cambiar el título del modal a "Añadir Entidadesa"


        document.getElementById('head-text').innerHTML = 'Agregar entidad';
        // Habilitar todas las opciones del select de entidad padre
        const selectEntidad = document.getElementById('id_entidad');
        Array.from(selectEntidad.options).forEach((option) => {
            option.disabled = false;
        });
    });
    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function(event) {

            event.preventDefault();
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const descripcion = this.getAttribute('data-descripcion');
            const activo = this.getAttribute('data-activo');
            const id_entidad = this.getAttribute(
                'data-id_entidad'); // Obtener el id del entidad padre

            // Ajustar el formulario para la edición
            document.getElementById('add-entidades-form').action =
                `/rhu/entidades/${id}`;
            document.getElementById('add-entidades-form').method = 'POST';
            document.getElementById('add-entidades-form').innerHTML +=
                '<input type="hidden" name="_method" value="PUT">';

            // Asignar los valores al formulario
            document.getElementById('nombre').value = nombre;
            document.getElementById('descripcion').value = descripcion;
            document.getElementById('activo').value = activo;

            // Asignar el valor del entidad padre al campo select
            if (id_entidad) {
                document.getElementById('id_entidad').value = id_entidad;
            } else {
                document.getElementById('id_entidad').value = ''; // Ninguno (Raíz)
            }

            // Deshabilitar la opción del mismo entidad en el select para evitar seleccionar a sí mismo como padre
            const selectEntidad = document.getElementById('id_entidad');
            Array.from(selectEntidad.options).forEach((option) => {
                option.disabled = option.value === id;
            });

            // Cambiar el título del modal a "Editar entidad"
            document.getElementById('head-text').textContent = 'Editar entidad';

            // Abrir el modal
            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });
</script>
