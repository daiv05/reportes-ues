@php
    $headers = [
        ['text' => 'ID', 'align' => 'center'],
        ['text' => 'Nombre', 'align' => 'left'],
        ['text' => 'Tiempo promedio límite', 'align' => 'left'],
        ['text' => 'Descripción', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acción', 'align' => 'left'],
    ];

    $unidadesTiempo = [
        'minutos' => 'Minutos',
        'horas' => 'Horas',
        'dias' => 'Días',
        'meses' => 'Meses',
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de categorías de reportes" />
        <div class="p-6">
            @canany(['CATEGORIAS_REPORTES_CREAR'])
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
                action="{{ route('categoriaReportes.index') }}"
                method="GET"
                class="mt-4 flex w-full flex-row flex-wrap items-center space-x-8"
            >
                <div class="flex w-full flex-col px-4 md:w-2/6 md:px-0">
                    <x-forms.row :columns="1">
                        <x-forms.field
                            id="nombre"
                            label="Nombre"
                            name="nombre-filter"
                            :value="request('nombre-filter')"
                        />
                    </x-forms.row>
                </div>
                <div class="relative flex flex-wrap space-x-4">
                    <button
                        type="submit"
                        data-tooltip-target="tooltip-aplicar-filtros"
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
                        onclick="window.location.href='{{ route('categoriaReportes.index') }}';"
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
                @if ($categoriasReportes->isEmpty())
                    <x-table.td colspan="{{ count($headers) }}" justify="center">
                        <span class="text-gray-500">No se encontraron registros</span>
                    </x-table.td>
                @endif

                @foreach ($categoriasReportes as $categoria)
                    <x-table.tr>
                        <x-table.td justify="center">{{ $categoria->id }}</x-table.td>
                        <x-table.td>{{ $categoria->nombre }}</x-table.td>
                        <x-table.td>{{ $categoria->tiempo_promedio . ' ' . $categoria->unidad_tiempo }}</x-table.td>
                        <x-table.td>{{ $categoria->descripcion }}</x-table.td>
                        <x-table.td justify="center">
                            <x-status.is-active :active="$categoria->activo" />
                        </x-table.td>
                        <x-table.td>
                            <div class="relative flex justify-center space-x-2">
                                @canany(['CATEGORIAS_REPORTES_EDITAR'])
                                    <a
                                        href="#"
                                        class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                        data-id="{{ $categoria->id }}"
                                        data-nombre="{{ $categoria->nombre }}"
                                        data-descripcion="{{ $categoria->descripcion }}"
                                        data-tiempo-prpmedio="{{ $categoria->tiempo_promedio }}"
                                        data-unidad-tiempo="{{ $categoria->unidad_tiempo }}"
                                        data-activo="{{ $categoria->activo }}"
                                        data-tooltip-target="tooltip-edit-{{ $categoria->id }}"
                                    >
                                        <x-heroicon-o-pencil class="h-5 w-5" />
                                    </a>

                                    <div
                                        id="tooltip-edit-{{ $categoria->id }}"
                                        role="tooltip"
                                        class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-green-700 px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                                    >
                                        Editar tipo de bien
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
            {{ $categoriasReportes->links() }}
        </nav>
    </x-container>
    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 id="modal-title" class="text-2xl font-bold text-escarlata-ues">Añadir categoría de reportes</h3>
        </x-slot>
        <x-slot name="body">
            <form id="categoria-reporte-form" method="POST" action="{{ route('categoriaReportes.store') }}">
                @csrf
                <div id="general-errors" class="mb-4 text-sm text-red-500"></div>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.field
                            id="nombre"
                            label="Nombre"
                            pattern="^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s\-,()]{1,50}$"
                            patternMessage="Solo se permiten 50 caracteres que sean letras, números, parentesis, comas o espacios."
                            name="nombre"
                            :value="old('nombre')"
                            :error="$errors->get('nombre')"
                            required
                        />
                        <div id="nombre-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="2">
                    <div>
                        <x-forms.field
                            id="tiempo_promedio"
                            label="Tiempo promedio"
                            type="number"
                            name="tiempo_promedio"
                            :value="old('tiempo_promedio')"
                            :error="$errors->get('tiempo_promedio')"
                            required
                        />
                        <div id="tiempo_promedio-error" class="text-sm text-red-500"></div>
                    </div>
                    <div>
                        <x-forms.select
                            label="Unidad de tiempo"
                            id="unidad_tiempo"
                            name="unidad_tiempo"
                            :options="$unidadesTiempo"
                            :selected="old('unidad_tiempo')"
                            :error="$errors->get('unidad_tiempo')"
                            required
                        />
                        <div id="unidad_tiempo-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.textarea
                            required
                            name="descripcion"
                            label="Descripción"
                            rows="4"
                            pattern="^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ,¡! _-]{1,250}$"
                            patternMessage="Solo se permiten 250 caracteres que sean letras, números, puntos o espacios"
                            :value="old('descripcion')"
                            :error="$errors->get('descripcion')"
                            placeholder="Describa brevemente la categoría del reporte..."
                        />
                        <div id="descripcion-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.select
                            label="Estado"
                            id="activo"
                            name="activo"
                            :options="['1' => 'ACTIVO', '0' => 'INACTIVO']"
                            :selected="old('activo', '1')"
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
                form="categoria-reporte-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4"
            >
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>
<script>
    unidadesTiempo = @json($unidadesTiempo);
    document.getElementById('categoria-reporte-form').addEventListener('submit', function (event) {
        const nombreField = document.getElementById('nombre');
        const descripcionField = document.getElementById('descripcion');
        const tiempoPromedioField = document.getElementById('tiempo_promedio');
        const unidadTiempoField = document.getElementById('unidad_tiempo');
        const estadoField = document.getElementById('activo');

        const patternErrors = document.querySelectorAll('div[id*="pattern-error"]');

        let hasErrors = false;

        document.getElementById('general-errors').innerHTML = '';
        document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));

        if (!nombreField.value.trim()) {
            hasErrors = true;
            document.getElementById('nombre-error').innerHTML = 'El campo nombre es obligatorio';
        } else {
            document.getElementById('nombre-error').innerHTML = '';
        }

        if (!descripcionField.value.trim()) {
            hasErrors = true;
            document.getElementById('descripcion-error').innerHTML = 'El campo descripción es obligatorio';
        } else {
            document.getElementById('descripcion-error').innerHTML = '';
        }

        if (!tiempoPromedioField.value) {
            hasErrors = true;
            document.getElementById('tiempo_promedio-error').innerHTML = 'El campo tiempo promedio es obligatorio';
        } else {
            if(tiempoPromedioField.value < 0) {
                hasErrors = true;
                document.getElementById('tiempo_promedio-error').innerHTML = 'El campo tiempo promedio debe ser mayor a 0';
            } else {
                document.getElementById('tiempo_promedio-error').innerHTML = '';
            }
        }

        if (!unidadTiempoField.value.trim()) {
            hasErrors = true;
            document.getElementById('unidad_tiempo-error').innerHTML = 'El campo unidad de tiempo es obligatorio';
        } else {
            if (!unidadesTiempo.hasOwnProperty(unidadTiempoField.value)) {
                hasErrors = true;
                document.getElementById('unidad_tiempo-error').innerHTML = 'La unidad de tiempo seleccionada no es válida';
            } else {
                document.getElementById('unidad_tiempo-error').innerHTML = '';
            }
        }

        if (!estadoField.value.trim()) {
            hasErrors = true;
            document.getElementById('estado-error').innerHTML = 'El campo estado es obligatorio';
        } else {
            document.getElementById('estado-error').innerHTML = '';
        }

        if (hasErrors) {
            event.preventDefault();
            document.getElementById('general-errors').innerHTML = 'Todos los campos son requeridos';
        } else {
            document.getElementById('general-errors').innerHTML = '';
        }

        if (patternErrors.length > 0) {
            event.preventDefault();
        }
    });

    document.querySelectorAll('[data-modal-hide="static-modal"]').forEach((button) => {
        button.addEventListener('click', function () {
            updateModalTitle('Añadir Tipo de Bien');

            resetForm();

            document.getElementById('categoria-reporte-form').method = 'POST';
            document.getElementById('categoria-reporte-form').action = '{{ route('tiposBienes.store') }}';

            document.querySelectorAll('input[name="_method"]').forEach((input) => input.remove());
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const tiempoPromedio = parseInt(this.getAttribute('data-tiempo-prpmedio'));
            const unidadTiempo = this.getAttribute('data-unidad-tiempo');
            const descripcion = this.getAttribute('data-descripcion');
            const activo = this.getAttribute('data-activo');

            updateModalTitle('Editar categoría de reportes]');

            document.getElementById('categoria-reporte-form').action = `/mantenimientos/categorias-reportes/${id}`;
            document.getElementById('categoria-reporte-form').method = 'POST';

            if (!document.querySelector('input[name="_method"]')) {
                document.getElementById('categoria-reporte-form').innerHTML +=
                    '<input type="hidden" name="_method" value="PUT">';
            }

            document.getElementById('nombre').value = nombre;
            document.getElementById('descripcion').value = descripcion;
            document.getElementById('tiempo_promedio').value = tiempoPromedio;
            document.getElementById('unidad_tiempo').value = unidadTiempo;
            document.getElementById('activo').value = activo;

            // Abrir el modal
            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });

    function updateModalTitle(title) {
        document.getElementById('modal-title').textContent = title;
    }

    function resetForm() {
        document.getElementById('categoria-reporte-form').reset();
        document.getElementById('general-errors').innerHTML = '';

        document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));

        document.querySelectorAll('select').forEach((select) => {
            select.selectedIndex = 0;
        });
    }
</script>
