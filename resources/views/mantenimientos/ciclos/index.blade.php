@php
    $headers = [
        ['text' => 'Año', 'align' => 'center'],
        ['text' => 'Tipo de Ciclo', 'align' => 'center'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acción', 'align' => 'center'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de Ciclos" />
        <div class="p-6">
            @canany(['CICLOS_CREAR'])
                <x-forms.primary-button
                    data-modal-target="static-modal"
                    data-modal-toggle="static-modal"
                    class="block"
                    type="button"
                    id="add-button"
                >
                    Añadir Ciclo
                </x-forms.primary-button>
            @endcanany
        </div>
    </x-slot>

    <x-container>
        <div
            class="flex w-full flex-col flex-wrap items-center justify-between space-y-4 pb-4 sm:flex-row sm:space-y-0"
        >
            <form
                action="{{ route('ciclos.index') }}"
                method="GET"
                class="mt-4 flex w-full flex-row flex-wrap items-center space-x-8"
            >
                <div class="flex w-full flex-col px-4 md:w-2/6 md:px-0">
                    <x-forms.row :columns="1">
                        <x-forms.field
                            id="materia"
                            label="Año"
                            name="nombre-filter"
                            :value="request('nombre-filter')"
                        />
                    </x-forms.row>
                </div>
                <div class="relative flex flex-wrap space-x-4">
                    <button
                        type="submit"
                        data-tooltip-target="tooltip-aplicar-filtros"
                        data-tooltip-placement="top"
                        class="inline-flex items-center rounded-full border border-transparent bg-escarlata-ues px-3 py-3 align-middle text-sm font-medium text-white shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
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
                        class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-escarlata-ues px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                    >
                        Aplicar filtros
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>

                    <button
                        type="reset"
                        class="inline-flex items-center rounded-full border border-gray-500 bg-white px-3 py-3 align-middle text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                        onclick="window.location.href='{{ route('ciclos.index') }}';"
                        data-tooltip-target="tooltip-limpiar-filtros"
                        data-tooltip-placement="top"
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
                        class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-gray-200 px-3 py-2 !text-center text-sm font-medium text-escarlata-ues opacity-0 transition-opacity duration-300 dark:bg-gray-700"
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
                @if ($ciclos->isEmpty())
                    <x-table.td colspan="{{ count($headers) }}" justify="center">
                        <span class="text-gray-500">No se encontraron registros</span>
                    </x-table.td>
                @endif

                @foreach ($ciclos as $ciclo)
                    <x-table.tr>
                        <x-table.td justify="center">
                            {{ $ciclo->anio }}
                        </x-table.td>
                        <x-table.td justify="center">
                            {{ $ciclo->tipoCiclo->nombre }}
                        </x-table.td>
                        <x-table.td justify="center">
                            <x-status.is-active :active="$ciclo->activo" />
                        </x-table.td>
                        <x-table.td justify="center">
                            <div class="relative flex justify-center space-x-2">
                                @canany(['CICLOS_EDITAR'])
                                    <a
                                        href="#"
                                        class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                        data-id="{{ $ciclo->id }}"
                                        data-anio="{{ $ciclo->anio }}"
                                        data-tipo_ciclo="{{ $ciclo->id_tipo_ciclo }}"
                                        data-estado="{{ $ciclo->activo }}"
                                        data-tooltip-target="tooltip-edit-{{ $ciclo->id }}"
                                    >
                                        <x-heroicon-o-pencil class="h-5 w-5" />
                                    </a>
                                    <div
                                        id="tooltip-edit-{{ $ciclo->id }}"
                                        role="tooltip"
                                        class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-green-700 px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                                    >
                                        Editar ciclo
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                @endcanany
                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.base>
        </div>
        <nav
            class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row"
            aria-label="Table navigation"
        >
            {{ $ciclos->links() }}
        </nav>
    </x-container>

    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 id="modal-title" class="text-2xl font-bold text-escarlata-ues">Añadir Ciclo</h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-ciclo-form" method="POST" action="{{ route('ciclos.store') }}">
                @csrf
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.field
                            label="Año"
                            name="anio"
                            pattern="[0-9]{4}"
                            maxlength="4"
                            patternMessage="El año debe contener 4 dígitos sin caracteres especiales"
                            :value="old('anio')"
                            :error="$errors->get('anio')"
                            required
                        />
                        <div id="anio-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.select
                            label="Tipo de Ciclo"
                            id="id_tipo_ciclo"
                            name="id_tipo_ciclo"
                            :options="$tiposCiclos"
                            :value="old('id_tipo_ciclo')"
                            :error="$errors->get('id_tipo_ciclo')"
                            required
                        />
                        <div id="tipo-ciclo-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.select
                            label="Estado"
                            id="activo"
                            name="activo"
                            :options="$estados"
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
                form="add-ciclo-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4"
            >
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>

<script>
    document.getElementById('add-ciclo-form').addEventListener('submit', function (event) {
        const anio = document.getElementById('anio').value.trim();
        const tipoCiclo = document.getElementById('id_tipo_ciclo').value.trim();
        const estado = document.getElementById('activo').value.trim();

        let hasErrors = false;

        if (!anio) {
            hasErrors = true;
            document.getElementById('anio-error').innerHTML = 'El campo año es obligatorio';
        } else {
            const anioActual = new Date().getFullYear();
            // Validar que el año se pueda registrar al menos un año antes del valor del input
            if (anio < anioActual - 1) {
                hasErrors = true;
                document.getElementById('anio-error').innerHTML = 'El año no puede ser menor a ' + (anioActual - 1);
            } else {
                document.getElementById('anio-error').innerHTML = '';
            }
        }

        if (!tipoCiclo) {
            hasErrors = true;
            document.getElementById('tipo-ciclo-error').innerHTML = 'El campo tipo ciclo es obligatorio';
        } else {
            document.getElementById('tipo-ciclo-error').innerHTML = '';
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
    });

    document.querySelectorAll('[data-modal-hide="static-modal"]').forEach((button) => {
        button.addEventListener('click', function () {
            updateTitle('Añadir Ciclo');
            document.getElementById('add-ciclo-form').action = '{{ route('ciclos.store') }}';
            document.getElementById('add-ciclo-form').method = 'POST';
            method = document.querySelector('[name="_method"]');
            if (method) document.getElementById('add-ciclo-form').removeChild(method);
            document.getElementById('add-ciclo-form').reset();
            document.getElementById('general-errors').innerHTML = '';
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const anio = this.getAttribute('data-anio');
            const tipoCiclo = this.getAttribute('data-tipo_ciclo');
            const estado = this.getAttribute('data-estado');

            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));

            updateTitle('Editar ciclo');

            document.getElementById('add-ciclo-form').action = `/mantenimientos/ciclos/${id}`;
            document.getElementById('add-ciclo-form').method = 'POST';
            document.getElementById('add-ciclo-form').innerHTML += '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('anio').value = anio;
            document.getElementById('id_tipo_ciclo').value = tipoCiclo;
            document.getElementById('activo').value = estado;

            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });

    function updateTitle(title) {
        document.getElementById('modal-title').textContent = title;
    }
</script>
