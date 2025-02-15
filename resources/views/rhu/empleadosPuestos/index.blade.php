@php
    $headers = [
        ['text' => 'Empleado', 'align' => 'left'],
        ['text' => 'Entidad', 'align' => 'left'],
        ['text' => 'Puesto', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acciones', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.main
            tituloMenor="Gestión de"
            tituloMayor="EMPLEADOS"
            subtitulo="Gestiona los puestos asignados a los empleados de la universidad"
        >
            <x-slot name="acciones">
                @canany(['ASIGNAR_PUESTOS_EMPLEADOS'])
                    <x-forms.primary-button
                        data-modal-target="static-modal"
                        data-modal-toggle="static-modal"
                        class="block"
                        type="button"
                        id="add-button"
                    >
                        Asignar puesto
                    </x-forms.primary-button>

                    <x-forms.primary-button
                        data-modal-target="static-modal-excel"
                        data-modal-toggle="static-modal-excel"
                        class="block"
                        type="button"
                    >
                        Importar datos
                    </x-forms.primary-button>

                    <x-forms.primary-button id="descargarEmpleadosBtn" class="relative block" type="button">
                        Descargar Formato
                    </x-forms.primary-button>
                @endcanany
            </x-slot>
        </x-header.main>
    </x-slot>

    <x-container>
        {{-- Filtros --}}
        <div
            class="flex w-full flex-col flex-wrap items-center justify-between space-y-4 pb-4 sm:flex-row sm:space-y-0"
        >
            <form
                action="{{ route('empleadosPuestos.index') }}"
                method="GET"
                class="mt-4 flex w-full flex-row flex-wrap items-center space-x-8"
            >
                <div class="flex w-full flex-col px-4 md:w-5/6 md:px-0">
                    <x-forms.row :columns="3">
                        <x-forms.field
                            id="empleado-filtro"
                            label="Nombre de empleado"
                            name="empleado-filtro"
                            :value="request('empleado-filtro')"
                        />
                        <x-forms.select
                            label="Entidad"
                            id="entidad-filtro"
                            name="entidad-filtro"
                            :options="$entidades"
                            :selected="request('entidad-filtro')"
                            onchange="filtrarPuestosFiltro()"
                        />
                        <x-forms.select
                            label="Puesto"
                            id="puesto-filtro"
                            name="puesto-filtro"
                            :options="$puestos[request('entidad-filtro')] ?? []"
                            :selected="request('puesto-filtro')"
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
                        onclick="window.location.href='{{ route('empleadosPuestos.index') }}';"
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
        <div>
            <div class="overflow-x-auto">
                <x-table.base :headers="$headers">
                    @if ($empleadosPuestos->isEmpty())
                        <x-table.td colspan="{{ count($headers) }}" justify="center">
                            <span class="text-gray-500">No se encontraron registros</span>
                        </x-table.td>
                    @endif

                    @foreach ($empleadosPuestos as $empPuesto)
                        <x-table.tr>
                            <x-table.td>
                                {{ $empPuesto->usuario->persona->nombre . ' ' . $empPuesto->usuario->persona->apellido }}
                            </x-table.td>
                            <x-table.td>{{ $empPuesto->puesto->entidad->nombre }}</x-table.td>
                            <x-table.td>{{ $empPuesto->puesto->nombre }}</x-table.td>
                            <x-table.td justify="center">
                                <x-status.is-active :active="$empPuesto->activo" />
                            </x-table.td>
                            <x-table.td>
                                <div class="relative flex flex-wrap justify-center gap-2">
                                    @canany(['EDITAR_PUESTOS_EMPLEADOS'])
                                        <a
                                            href="#"
                                            class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                            data-id="{{ $empPuesto->id }}"
                                            data-empleado="{{ $empPuesto->usuario->id }}"
                                            data-entidad="{{ $empPuesto->puesto->id_entidad }}"
                                            data-puesto="{{ $empPuesto->id_puesto }}"
                                            data-estado="{{ $empPuesto->activo }}"
                                            data-tooltip-target="tooltip-edit-{{ $empPuesto->id }}"
                                        >
                                            <x-heroicon-o-pencil class="h-5 w-5" />
                                        </a>

                                        <div
                                            id="tooltip-edit-{{ $empPuesto->id }}"
                                            role="tooltip"
                                            class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-green-700 px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                                        >
                                            Editar empleado
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    @endcanany

                                    @canany(['VER_PUESTOS_EMPLEADOS'])
                                        <a
                                            href="{{ url('recursos-humanos/empleados-puestos/' . $empPuesto->id) }}"
                                            class="view-button font-medium text-blue-600 hover:underline dark:text-blue-400"
                                            data-tooltip-target="tooltip-view-{{ $empPuesto->id }}"
                                        >
                                            <x-heroicon-o-eye class="h-5 w-5" />
                                        </a>

                                        <div
                                            id="tooltip-view-{{ $empPuesto->id }}"
                                            role="tooltip"
                                            class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-blue-700 px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                                        >
                                            Ver empleado
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
                {{ $empleadosPuestos->links() }}
            </nav>
        </div>
    </x-container>

    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 id="modal-title" class="text-2xl font-bold text-escarlata-ues">Asignar puesto</h3>
        </x-slot>
        <x-slot name="body">
            <form id="asignacion-form" method="POST" action="{{ route('empleadosPuestos.store') }}">
                @csrf
                <div id="general-errors" class="mb-4 text-sm text-red-500"></div>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.searchable-select
                            id="empleado"
                            label="Empleado"
                            name="empleado"
                            :options="$empleados"
                            onchange="filtrarPuestos()"
                            searchable
                            required
                        />
                        <div id="empleado-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <div class="mb-4">
                    <x-forms.row :columns="2">
                        <div>
                            <x-forms.select
                                label="Entidad"
                                id="entidad"
                                name="entidad"
                                :options="$entidades"
                                :value="old('entidad')"
                                onchange="filtrarPuestos()"
                                required
                            />
                            <div id="entidad-error" class="mb-4 text-sm text-red-500"></div>
                        </div>
                        <div>
                            <x-forms.select
                                label="Puesto"
                                id="puesto"
                                name="puesto"
                                :options="$puestos[old('entidad')] ?? []"
                                :value="old('puesto')"
                                :error="$errors->get('puesto')"
                                required
                            />
                            <div id="puesto-error" class="mb-4 text-sm text-red-500"></div>
                        </div>
                    </x-forms.row>
                </div>
                <div class="mb-4">
                    <x-forms.select
                        label="Estado"
                        id="estado"
                        name="estado"
                        :options="$estados"
                        :selected="1"
                        :error="$errors->get('estado')"
                        required
                    />
                    <div id="estado-error" class="mb-4 text-sm text-red-500"></div>
                    @error('estado')
                        <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>
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
            <h3 id="modal-title" class="text-2xl font-bold text-escarlata-ues">Importar empleados</h3>
        </x-slot>
        <x-slot name="body">
            <form
                id="import-excel-empleados"
                action="{{ route('empleados.importar') }}"
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
                form="import-excel-empleados"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4"
            >
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>

<script>
    const empleados = @json($empleados);
    document.getElementById('asignacion-form').addEventListener('submit', function (event) {
        // valida los campos para mostrar el error
        const empleado = document.getElementById('empleado').value.trim();
        const entidad = document.getElementById('entidad').value.trim();
        const puesto = document.getElementById('puesto').value.trim();
        const estado = document.getElementById('estado').value.trim();

        let hasErrors = false;

        if (!empleado) {
            hasErrors = true;
            document.getElementById('empleado-error').innerHTML = 'El campo Empleado es obligatorio';
        }

        if (!entidad) {
            hasErrors = true;
            document.getElementById('entidad-error').innerHTML = 'El campo Entidad es obligatorio';
        }

        if (!puesto) {
            hasErrors = true;
            document.getElementById('puesto-error').innerHTML = 'El campo Puesto es obligatorio';
        }

        if (!estado) {
            hasErrors = true;
            document.getElementById('estado-error').innerHTML = 'El campo Estado es obligatorio';
        }

        if (hasErrors) {
            event.preventDefault();
            document.getElementById('general-errors').innerHTML = 'Todos los campos son requeridos';
        }
    });

    document.getElementById('import-excel-empleados').addEventListener('submit', function (event) {
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
            updateTitle('Asignar puesto');
            document.dispatchEvent(new Event('modal:open'));
            document.getElementById('asignacion-form').action = '{{ route('empleadosPuestos.store') }}';
            document.getElementById('asignacion-form').method = 'POST';
            method = document.querySelector('[name="_method"]');
            if (method) document.getElementById('asignacion-form').removeChild(method);
            document.getElementById('search-empleado').disabled = false;
            document.getElementById('search-empleado').classList.remove('!bg-gray-300');
            document.getElementById('search-empleado').value = null;
            document.getElementById('empleado').value = null;
            document.getElementById('entidad').disabled = false;
            document.getElementById('puesto').disabled = false;
            document.getElementById('asignacion-form').reset();
            document.getElementById('estado').value = 1;
            document.getElementById('general-errors').innerHTML = '';
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const entidad = this.getAttribute('data-entidad');
            const puesto = this.getAttribute('data-puesto');
            const estado = this.getAttribute('data-estado');
            const empleado = this.getAttribute('data-empleado');

            updateTitle('Editar asignación de puesto');

            document.getElementById('asignacion-form').action = `/recursos-humanos/empleados-puestos/${id}`;
            document.getElementById('asignacion-form').method = 'POST';
            document.getElementById('asignacion-form').innerHTML += '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('empleado').value = empleado;
            document.getElementById('search-empleado').value = empleados[empleado];
            document.getElementById('search-empleado').disabled = true;
            document.getElementById('search-empleado').readonly = true;
            document.getElementById('search-empleado').classList.add('!bg-gray-300');
            document.getElementById('entidad').value = entidad;
            document.getElementById('entidad').disabled = true;
            filtrarPuestos();
            document.getElementById('puesto').value = puesto;
            document.getElementById('puesto').disabled = true;
            document.getElementById('estado').value = estado;

            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });

    const puestosPorEntidad = @json($puestos);

    function filtrarPuestos() {
        const entidadId = document.querySelector('[name="entidad"]').value;
        const puestoSelect = document.querySelector('[name="puesto"]');

        // Limpiar el campo de puestos
        puestoSelect.innerHTML = '<option value="">Seleccionar Puesto</option>';

        if (entidadId && puestosPorEntidad[entidadId]) {
            // Agregar puestos filtrados al select
            Object.entries(puestosPorEntidad[entidadId]).forEach(([id, nombre]) => {
                const option = document.createElement('option');
                option.value = id;
                option.textContent = nombre;
                puestoSelect.appendChild(option);
            });
        }
    }

    function filtrarPuestosFiltro() {
        const entidadId = document.querySelector('[name="entidad-filtro"]').value;
        const puestoSelect = document.querySelector('[name="puesto-filtro"]');

        // Limpiar el campo de puestos
        puestoSelect.innerHTML = '<option value="">Seleccionar Puesto</option>';

        if (entidadId && puestosPorEntidad[entidadId]) {
            // Agregar puestos filtrados al select
            Object.entries(puestosPorEntidad[entidadId]).forEach(([id, nombre]) => {
                const option = document.createElement('option');
                option.value = id;
                option.textContent = nombre;
                puestoSelect.appendChild(option);
            });
        }
    }

    function updateTitle(title) {
        document.getElementById('modal-title').textContent = title;
    }

    function updateFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : 'Selecciona un archivo';
        document.getElementById('file-name').textContent = fileName;
    }

    function uploadFile() {
        document.getElementById('excel_file').click();
    }
</script>

<script>
    document.getElementById('descargarEmpleadosBtn').addEventListener('click', function () {
        this.innerHTML =
            document.getElementById('descargarEmpleadosBtn').textContent +
            `<div class="loader absolute transform left-[45%]"></div>`;
        this.disabled = true;
        this.classList.add('!text-escarlata-ues');

        fetch('/descargar/archivo/empleados', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                Accept: 'application/json',
            },
        })
            .then((response) => {
                if (response.ok) {
                    return response.blob();
                } else {
                    throw new Error('No se pudo descargar el archivo');
                }
            })
            .then((blob) => {
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'EMPLEADOS.xlsx';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            })
            .catch((error) => {
                console.error('Error al descargar el archivo:', error);
            })
            .finally(() => {
                this.innerHTML = 'Descargar Formato';
                this.disabled = false;
                this.classList.remove('!text-escarlata-ues');
            });
    });
</script>
