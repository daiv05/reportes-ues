@php
    $headers = [
        ['text' => 'Nombre', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acción', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de aulas" />
        <div class="p-6">
            @canany(['AULAS_CREAR'])
                <x-forms.primary-button
                    data-modal-target="static-modal"
                    data-modal-toggle="static-modal"
                    class="block"
                    type="button"
                >
                    Añadir
                </x-forms.primary-button>

                <x-forms.primary-button
                    data-modal-target="static-modal-excel"
                    data-modal-toggle="static-modal-excel"
                    class="block"
                    type="button"
                >
                    Importar datos
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
                action="{{ route('aulas.index') }}"
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
                        onclick="window.location.href='{{ route('aulas.index') }}';"
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
                @foreach ($aulas as $aula)
                    <x-table.tr>
                        <x-table.td>
                            {{ $aula->nombre }}
                        </x-table.td>
                        <x-table.td justify="center">
                            <x-status.is-active :active="$aula->activo" />
                        </x-table.td>
                        <x-table.td>
                            <div class="relative flex justify-center space-x-2">
                                @canany(['AULAS_EDITAR'])
                                    <a
                                        href="#"
                                        class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                        data-id="{{ $aula->id }}"
                                        data-nombre="{{ $aula->nombre }}"
                                        data-facultad="{{ $aula->facultad->id }}"
                                        data-activo="{{ $aula->activo }}"
                                        data-tooltip-target="tooltip-edit-{{ $aula->id }}"
                                    >
                                        <x-heroicon-o-pencil class="h-5 w-5" />
                                    </a>

                                    <div
                                        id="tooltip-edit-{{ $aula->id }}"
                                        role="tooltip"
                                        class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-green-700 px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                                    >
                                        Editar aula
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
            {{ $aulas->links() }}
        </nav>
    </x-container>
    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 id="modal-title" class="text-2xl font-bold text-escarlata-ues">Añadir Aula</h3>
        </x-slot>
        <x-slot name="body">
            <form id="asignacion-form" method="POST" action="{{ route('aulas.store') }}">
                @csrf
                <div id="general-errors" class="mb-4 text-sm text-red-500"></div>
                <x-forms.row :columns="1">
                    <x-forms.select
                        label="Facultad"
                        id="id_facultad"
                        name="id_facultad"
                        :options="$facultades->pluck('nombre', 'id')->toArray()"
                        :value="old('id_facultad')"
                        :error="$errors->get('id_facultad')"
                        required
                    />
                    <div id="facultad-error" class="text-sm text-red-500"></div>
                </x-forms.row>
                <x-forms.row :columns="2">
                    <div>
                        <x-forms.field
                            id="nombre"
                            label="Nombre"
                            name="nombre"
                            pattern="^[a-zA-Z0-9]{1,50}$"
                            patternMessage="Solo se permiten 50 caracteres que sean letras o números"
                            :value="old('nombre')"
                            :error="$errors->get('nombre')"
                            required
                        />
                        <div id="nombre-error" class="text-sm text-red-500"></div>
                    </div>
                    <div>
                        <x-forms.select
                            label="Estado"
                            id="activo"
                            name="activo"
                            :options="['1' => 'ACTIVO', '0' => 'INACTIVO']"
                            :value="old('activo', '1')"
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
                form="asignacion-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4"
            >
                Guardar
            </button>
        </x-slot>
    </x-form-modal>

    <!-- Modal Importación de Excel-->
    <x-form-modal id="static-modal-excel" class="hidden">
        <x-slot name="header">
            <h3 id="modal-title" class="text-2xl font-bold text-escarlata-ues">Importar locales</h3>
        </x-slot>
        <x-slot name="body">
            <form
                id="import-excel-aulas"
                action="{{ route('aulas.importar') }}"
                method="POST"
                enctype="multipart/form-data"
                class="grid grid-cols-1 gap-4"
            >
                @csrf
                <div class="mx-auto flex w-full flex-col items-center justify-center gap-3">
                    <label
                        for="file"
                        class="flex w-64 cursor-pointer flex-col items-center rounded-lg border border-orange-900 bg-white px-4 py-6 uppercase tracking-wide text-orange-900 shadow-lg hover:bg-orange-900 hover:text-white"
                        onclick="uploadFile()"
                    >
                        <x-heroicon-o-cloud-arrow-up class="h-10 w-10" />
                        <span id="file-name" class="mt-2 text-base leading-normal">Selecciona un archivo</span>
                        <input
                            type="file"
                            name="excel_file"
                            accept=".xls,.xlsx,.csv"
                            id="excel_file"
                            class="hidden"
                            onchange="updateFileName(this)"
                        />
                        @if ($errors->has('excel_file'))
                            <span class="text-center text-sm text-red-500">{{ $errors->first('excel_file') }}</span>
                        @endif
                    </label>
                    <div id="excel-error" class="text-sm text-red-500"></div>
                </div>
            </form>
        </x-slot>
        <x-slot name="footer">
            <button
                data-modal-hide="static-modal-excel"
                type="button"
                class="rounded-lg border bg-gray-700 px-7 py-2.5 text-sm font-medium text-white focus:z-10 focus:outline-none focus:ring-4"
            >
                Cancelar
            </button>
            <button
                type="submit"
                form="import-excel-aulas"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4"
            >
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>
<script>
    document.getElementById('asignacion-form').addEventListener('submit', function (event) {
        const nombreField = document.getElementById('nombre');
        const facultadField = document.getElementById('id_facultad');
        const estadoField = document.getElementById('activo');

        const patternErrors = document.querySelectorAll('div[id*="pattern-error"]');

        let hasErrors = false;

        document.getElementById('general-errors').innerHTML = '';
        document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));

        if (!nombreField.value.trim()) {
            hasErrors = true;
            document.getElementById('nombre-error').innerHTML = 'El campo Nombre es obligatorio';
        } else {
            document.getElementById('nombre-error').innerHTML = '';
        }

        if (!facultadField.value.trim()) {
            hasErrors = true;
            document.getElementById('facultad-error').innerHTML = 'El campo Facultad es obligatorio';
        } else {
            document.getElementById('facultad-error').innerHTML = '';
        }

        if (!estadoField.value.trim()) {
            hasErrors = true;
            document.getElementById('estado-error').innerHTML = 'El campo Estado es obligatorio';
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

    document.getElementById('import-excel-aulas').addEventListener('submit', function (event) {
        const excelFile = document.getElementById('excel_file').value.trim();
        let hasErrors = false;

        if (!excelFile) {
            // Cambiado: no usar .value ya que es un valor ya extraído
            hasErrors = true;
            document.getElementById('excel-error').innerHTML = 'El archivo es obligatorio';
        } else {
            const extension = excelFile.split('.').pop().toLowerCase();
            if (extension !== 'xls' && extension !== 'xlsx' && extension !== 'csv') {
                hasErrors = true;
                document.getElementById('excel-error').innerHTML = 'El archivo debe ser de tipo Excel o CSV';
            }
        }

        if (hasErrors) {
            event.preventDefault();
        }
    });

    document.querySelectorAll('[data-modal-hide="static-modal"]').forEach((button) => {
        button.addEventListener('click', function () {
            updateModalTitle('Añadir Aula');

            resetForm();

            document.getElementById('asignacion-form').method = 'POST';
            document.getElementById('asignacion-form').action = '{{ route('aulas.store') }}';

            document.querySelectorAll('input[name="_method"]').forEach((input) => input.remove());
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const facultad = this.getAttribute('data-facultad');
            const activo = this.getAttribute('data-activo');

            updateModalTitle('Editar Aula');

            document.getElementById('asignacion-form').action = `/mantenimientos/aulas/${id}`;
            document.getElementById('asignacion-form').method = 'POST';

            if (!document.querySelector('input[name="_method"]')) {
                document.getElementById('asignacion-form').innerHTML +=
                    '<input type="hidden" name="_method" value="PUT">';
            }

            document.getElementById('nombre').value = nombre;
            document.getElementById('id_facultad').value = facultad;
            document.getElementById('activo').value = activo;

            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });

    function updateModalTitle(title) {
        document.getElementById('modal-title').textContent = title;
    }

    function resetForm() {
        document.getElementById('asignacion-form').reset();
        document.getElementById('general-errors').innerHTML = '';

        document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));

        document.querySelectorAll('select').forEach((select) => {
            select.selectedIndex = 0;
        });
    }

    function updateFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : 'Selecciona un archivo';
        document.getElementById('file-name').textContent = fileName;
    }

    function uploadFile() {
        document.getElementById('excel_file').click();
    }
</script>
