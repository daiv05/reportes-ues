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
        <div class="p-6">
            @canany(['ENTIDADES_CREAR'])
                <x-forms.primary-button
                    data-modal-target="static-modal"
                    data-modal-toggle="static-modal"
                    class="block"
                    type="button"
                >
                    Añadir
                </x-forms.primary-button>
            @endcanany
        </div>
    </x-slot>

    <x-container>
        {{-- Filtros --}}
        <div
            class="flex w-full flex-col flex-wrap items-center justify-between space-y-4 pb-4 sm:flex-row sm:space-y-0"
        >
            <form
                action="{{ route('entidades.index') }}"
                method="GET"
                class="mt-4 flex w-full flex-row flex-wrap items-center space-x-8"
            >
                <div class="flex w-full flex-col px-4 md:w-2/6 md:px-0">
                    <x-forms.row :columns="1">
                        <x-forms.field
                            id="materia"
                            label="Nombre"
                            name="nombre-filter"
                            :value="request('nombre-filter')"
                        />
                    </x-forms.row>
                </div>
                <div class="flex flex-wrap space-x-4">
                    <button
                        type="submit"
                        class="inline-flex items-center rounded-full border border-transparent bg-escarlata-ues px-3 py-3 align-middle text-sm font-medium text-white shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                        data-tooltip-target="tooltip-aplicar-filtros"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-4 w-4"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
                            />
                        </svg>
                    </button>

                    <div
                        id="tooltip-aplicar-filtros"
                        role="tooltip"
                        class="shadow-xs tooltip z-40 inline-block rounded-lg bg-escarlata-ues px-3 py-2 text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                    >
                        Aplicar filtros
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>

                    <button
                        type="reset"
                        class="inline-flex items-center rounded-full border border-gray-500 bg-white px-3 py-3 align-middle text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                        onclick="window.location.href='{{ route('entidades.index') }}';"
                        data-tooltip-target="tooltip-limpiar-filtros"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-4 w-4"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div
                        id="tooltip-limpiar-filtros"
                        role="tooltip"
                        class="shadow-xs tooltip z-40 inline-block rounded-lg bg-gray-200 px-3 py-2 text-sm font-medium text-escarlata-ues opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                    >
                        Limpiar filtros
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>
            </form>
        </div>

        {{-- TABLA --}}
        <div class="mx-auto mb-6 flex flex-col overflow-x-auto sm:rounded-lg">
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
                        <x-table.td justify="center">
                            <x-status.is-active :active="$entidad->activo" />
                        </x-table.td>
                        <x-table.td justify="center">
                            @canany(['ENTIDADES_EDITAR'])
                                <a
                                    href="#"
                                    class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                    data-id="{{ $entidad->id }}"
                                    data-nombre="{{ $entidad->nombre }}"
                                    data-descripcion="{{ $entidad->descripcion }}"
                                    data-estado="{{ $entidad->activo }}"
                                    data-id_entidad="{{ $entidad->id_entidad }}"
                                    data-tooltip-target="tooltip-edit-{{ $entidad->id }}"
                                >
                                    <x-heroicon-o-pencil class="h-5 w-5" />
                                </a>

                                <div
                                    id="tooltip-edit-{{ $entidad->id }}"
                                    role="tooltip"
                                    class="shadow-xs tooltip z-40 inline-block rounded-lg bg-green-700 px-3 py-2 text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                                >
                                    Editar entidad
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            @endcanany
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.base>
        </div>
        <nav
            class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row"
            aria-label="Table navigation"
        >
            {{ $entidades->links() }}
        </nav>
    </x-container>

    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 id="modal-title" class="text-2xl font-bold text-escarlata-ues">Añadir entidad</h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-entidades-form" method="POST" action="{{ route('entidades.store') }}">
                @csrf
                <x-forms.row :columns="1">
                    <input type="hidden" name="id" id="id" />
                    <div>
                        <x-forms.field
                            label="Nombre"
                            name="nombre"
                            type="text"
                            pattern="^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ ]{1,50}$"
                            patternMessage="Solo se permiten 50 caracteres que sean letras, números, puntos o espacios"
                            :value="old('nombre')"
                            :error="$errors->get('nombre')"
                            required
                        />
                        <div id="nombre-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.textarea
                            required
                            name="descripcion"
                            label="Descripción"
                            rows="4"
                            pattern="^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ ]{1,250}$"
                            patternMessage="Solo se permiten 250 caracteres que sean letras, números, puntos o espacios"
                            :value="old('descripcion')"
                            :error="$errors->get('descripcion')"
                            placeholder="Describa brevemente las funciones..."
                        />
                        <div id="descripcion-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.select
                            label="Entidad Padre"
                            id="id_entidad"
                            name="id_entidad"
                            :options="['' => 'Ninguno (Raíz)'] + $entidadesLista->pluck('nombre', 'id')->toArray()"
                            :value="old('id_entidad')"
                            :error="$errors->get('id_entidad')"
                        />
                        <div id="entidad-padre-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.select
                            label="Estado"
                            id="activo"
                            name="activo"
                            :options="[1 => 'ACTIVO', 0 => 'INACTIVO']"
                            :selected="1"
                            :error="$errors->get('activo')"
                            required
                        />
                        <div id="estado-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
            </form>
        </x-slot>
        <x-slot name="footer">
            <button
                data-modal-hide="static-modal"
                type="button"
                class="rounded-lg border bg-gray-700 px-7 py-2.5 text-sm font-medium text-white focus:z-10 focus:outline-none focus:ring-4"
            >
                Cancelar
            </button>
            <button
                type="submit"
                form="add-entidades-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4"
            >
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>
<script>
    document.getElementById('add-entidades-form').addEventListener('submit', function (event) {
        const id = document.getElementById('id').value.trim();
        const entidadPadre = document.getElementById('id_entidad').value.trim();
        const descripcion = document.getElementById('descripcion').value.trim();
        const nombre = document.getElementById('nombre').value.trim();
        const estado = document.getElementById('activo').value.trim();

        const patternErrors = document.querySelectorAll('div[id*="pattern-error"]');

        let hasErrors = false;

        if (!!entidadPadre && entidadPadre === id) {
            hasErrors = true;
            document.getElementById('entidad-padre-error').innerHTML =
                'No puedes seleccionar a la misma entidad como padre';
        } else {
            document.getElementById('entidad-padre-error').innerHTML = '';
        }

        if (!nombre) {
            hasErrors = true;
            document.getElementById('nombre-error').innerHTML = 'El campo nombre es obligatorio';
        } else {
            document.getElementById('nombre-error').innerHTML = '';
        }

        if (!descripcion) {
            hasErrors = true;
            document.getElementById('descripcion-error').innerHTML = 'El campo descripción es obligatorio';
        } else {
            document.getElementById('descripcion-error').innerHTML = '';
        }

        if (!estado) {
            hasErrors = true;
            document.getElementById('estado-error').innerHTML = 'El campo estado es obligatorio';
        } else {
            document.getElementById('estado-error').innerHTML = '';
        }

        if (hasErrors) {
            event.preventDefault();
        }

        if (patternErrors.length > 0) {
            event.preventDefault();
        }
    });

    document.querySelectorAll('[data-modal-hide="static-modal"]').forEach((button) => {
        button.addEventListener('click', function () {
            updateTitle('Añadir entidad');

            const selectEntidad = document.getElementById('id_entidad');
            Array.from(selectEntidad.options).forEach((option) => {
                option.disabled = false;
            });

            document.getElementById('add-entidades-form').action = '{{ route('entidades.store') }}';
            document.getElementById('add-entidades-form').method = 'POST';
            let method = document.querySelector('[name="_method"]');
            if (method) document.getElementById('add-entidades-form').removeChild(method);

            document.querySelectorAll('_method').forEach((input) => input.remove());

            document.getElementById('add-entidades-form').reset();
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function (event) {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const descripcion = this.getAttribute('data-descripcion');
            const estado = this.getAttribute('data-estado');
            const id_entidad = this.getAttribute('data-id_entidad'); // Obtener el id del entidad padre

            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));

            updateTitle('Editar entidad');

            // Ajustar el formulario para la edición
            document.getElementById('add-entidades-form').action = `/recursos-humanos/entidades/${id}`;
            document.getElementById('add-entidades-form').method = 'POST';
            if (!document.querySelector('input[name="_method"]')) {
                document
                    .getElementById('add-entidades-form')
                    .insertAdjacentHTML('beforeend', '<input type="hidden" name="_method" value="PUT">');
            }

            // Asignar los valores al formulario
            document.getElementById('nombre').value = nombre;
            document.getElementById('descripcion').value = descripcion;
            document.getElementById('activo').value = estado;
            document.getElementById('id').value = id;

            // Asignar el valor del entidad padre al campo select
            if (id_entidad) {
                document.getElementById('id_entidad').value = id_entidad;
            } else {
                document.getElementById('id_entidad').value = ''; // Ninguno (Raíz)
            }

            // Deshabilitar la opción del mismo entidad en el select para evitar seleccionar a sí mismo como padre
            const selectEntidad = document.getElementById('id_entidad');
            Array.from(selectEntidad.options).forEach((option) => {
                if (option.value === id) {
                    option.disabled = true;
                }
            });

            // Abrir el modal
            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });
    function updateTitle(title) {
        document.getElementById('modal-title').textContent = title;
    }
</script>
