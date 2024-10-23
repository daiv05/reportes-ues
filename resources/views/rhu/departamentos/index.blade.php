@php
    $headers = [
        ['text' => 'Nombre', 'align' => 'left'],
        ['text' => 'Descripción', 'align' => 'left'],
        ['text' => 'Departamento Padre', 'align' => 'left'], // Nueva columna
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acciones', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de Departamentos" />
    </x-slot>

    <div>
        <div class="p-6">
            <x-forms.primary-button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block"
                type="button" id="add-button">
                Añadir
            </x-forms.primary-button>
        </div>
        <div class="mx-auto mb-8 flex flex-col items-center justify-center overflow-x-auto sm:rounded-lg">
            <x-table.base :headers="$headers">
                @foreach ($departamentos as $depa)
                    <x-table.tr>
                        <x-table.td>
                            {{ $depa->nombre }}
                        </x-table.td>
                        <x-table.td>
                            {{ $depa->descripcion }}
                        </x-table.td>
                        <x-table.td>
                            {{-- Mostrar el departamento padre o "Raíz" si es null --}}
                            {{ $depa->id_departamento ? $depa->padre->nombre : 'Raíz' }}
                        </x-table.td>
                        <x-table.td>
                            <x-status.is-active :active="$depa->activo" />
                        </x-table.td>
                        <x-table.td>
                            <a href="#"
                                class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                data-id="{{ $depa->id }}" data-nombre="{{ $depa->nombre }}"
                                data-descripcion="{{ $depa->descripcion }}" data-activo="{{ $depa->activo }}"
                                data-id_departamento="{{ $depa->id_departamento }}">
                                <x-heroicon-o-pencil class="h-5 w-5" />
                            </a>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.base>
            <nav class="flex-column flex flex-wrap items-center justify-between pt-4 md:flex-row"
                aria-label="Table navigation">
                {{ $departamentos->links() }}
            </nav>
        </div>
    </div>


    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 id="head-text" class="text-2xl font-bold text-escarlata-ues">Añadir Departamento</h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-departamentos-form" method="POST" action="{{ route('departamentos.store') }}">
                @csrf
                <div class="mb-4">
                    <x-forms.input-label for="nombre" :value="__('Nombre')" />
                    <input type="text" id="nombre" name="nombre"
                        class="mt-1 block w-full rounded-md border border-gray-300 py-2 pl-3 pr-3 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm" />
                    <x-forms.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-forms.input-label for="descripcion" :value="__('Descripcion')" />
                    <textarea id="descripcion" name="descripcion" rows="4"
                        class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        placeholder="Describa brevemente las funciones..."></textarea>
                    <x-forms.input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-forms.input-label for="id_departamento" :value="__('Departamento Padre')" />
                    <select id="id_departamento" name="id_departamento"
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-escarlata-ues focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm">
                        <option value="">Ninguno (Raíz)</option>
                        @foreach ($departamentosLista as $departamento)
                            <option value="{{ $departamento->id }}">
                                {{ $departamento->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <x-forms.input-error :messages="$errors->get('id_departamento')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-forms.input-label for="activo" :value="__('Estado')" />
                    <select id="activo" name="activo"
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-escarlata-ues focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm">
                        <option value="1">ACTIVO</option>
                        <option value="0">INACTIVO</option>
                    </select>
                    <x-forms.input-error :messages="$errors->get('activo')" class="mt-2" />
                </div>
            </form>
        </x-slot>
        <x-slot name="footer">
            <button data-modal-hide="static-modal" type="button"
                class="rounded-lg border bg-gray-700 px-7 py-2.5 text-sm font-medium text-white focus:z-10 focus:outline-none focus:ring-4">
                Cancelar
            </button>
            <button type="submit" form="add-departamentos-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>
<script>
    document.getElementById('add-departamentos-form').addEventListener('submit', function(event) {
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
            document.getElementById('add-departamentos-form').reset();
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
        });
    });

    document.getElementById('add-button').addEventListener('click', function(event) {
        // Cambiar el título del modal a "Añadir Departamento"


        document.getElementById('head-text').innerHTML = 'Agregar departamento';
        // Habilitar todas las opciones del select de departamento padre
        const selectDepartamento = document.getElementById('id_departamento');
        Array.from(selectDepartamento.options).forEach((option) => {
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
            const id_departamento = this.getAttribute(
                'data-id_departamento'); // Obtener el id del departamento padre

            // Ajustar el formulario para la edición
            document.getElementById('add-departamentos-form').action =
                `/mantenimientos/departamentos/${id}`;
            document.getElementById('add-departamentos-form').method = 'POST';
            document.getElementById('add-departamentos-form').innerHTML +=
                '<input type="hidden" name="_method" value="PUT">';

            // Asignar los valores al formulario
            document.getElementById('nombre').value = nombre;
            document.getElementById('descripcion').value = descripcion;
            document.getElementById('activo').value = activo;

            // Asignar el valor del departamento padre al campo select
            if (id_departamento) {
                document.getElementById('id_departamento').value = id_departamento;
            } else {
                document.getElementById('id_departamento').value = ''; // Ninguno (Raíz)
            }

            // Deshabilitar la opción del mismo departamento en el select para evitar seleccionar a sí mismo como padre
            const selectDepartamento = document.getElementById('id_departamento');
            Array.from(selectDepartamento.options).forEach((option) => {
                option.disabled = option.value == id;
            });

            // Cambiar el título del modal a "Editar departamento"
            document.getElementById('head-text').textContent = 'Editar departamento';

            // Abrir el modal
            document.querySelector('[data-modal-target="static-modal"]').click();;
        });
    });
</script>
