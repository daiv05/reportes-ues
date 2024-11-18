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
        <x-header.simple titulo="Gestión de puestos de los empleados" />
        <div class="p-6">
            <x-forms.primary-button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block"
            type="button" id="add-button">
                Asignar puesto
            </x-forms.primary-button>
        </div>
    </x-slot>

    <div>
        <div class="flex-col flex flex-wrap items-center justify-between space-y-4 pb-4 sm:flex-row sm:space-y-0">
            <form action="{{ route('empleadosPuestos.index') }}" method="GET" class="flex-row flex flex-wrap items-center space-x-8 mt-4">
                <div class="flex md:w-1/2 gap-4">
                    <x-forms.row :columns="2">
                        <x-forms.select label="Entidad" id="entidad-filtro" name="entidad-filtro" :options="$entidades" :value="request('entidad-filtro')" onchange="filtrarPuestosFiltro()" />
                        <x-forms.select label="Puesto" id="puesto-filtro" name="puesto-filtro" :options="$puestos[request('entidad-filtro')] ?? []" :value="request('puesto-filtro')" />
                    </x-forms.row>
                </div>
                <button type="submit"
                        class="align-middle h-fit rounded-full inline-flex items-center px-3 py-3 border border-transparent shadow-sm text-sm font-medium text-white bg-escarlata-ues hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                    </svg>
                </button>

                <button type="reset"
                        class="align-middle h-fit rounded-full inline-flex items-center px-3 py-3 shadow-sm text-sm font-medium bg-white border border-gray-500 text-gray-500 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                        onclick="window.location.href='{{ route('empleadosPuestos.index') }}';">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </form>
        </div>
        <div class="mx-auto mb-6 flex flex-col items-center justify-center overflow-x-auto sm:rounded-lg">
            <x-table.base :headers="$headers">
                @foreach ($empleadosPuestos as $empPuesto)
                    <x-table.tr>
                        <x-table.td>{{ $empPuesto->usuario->persona->nombre. ' '. $empPuesto->usuario->persona->apellido }}</x-table.td>
                        <x-table.td>{{ $empPuesto->puesto->entidad->nombre }}</x-table.td>
                        <x-table.td>{{ $empPuesto->puesto->nombre }}</x-table.td>
                        <x-table.td>
                            <x-status.is-active :active="$empPuesto->activo" />
                        </x-table.td>
                        <x-table.td>
                            <a href="#"
                                class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                data-id="{{ $empPuesto->id }}" data-empleado="{{ $empPuesto->usuario->id }}"
                                data-entidad="{{ $empPuesto->puesto->id_entidad }}" data-puesto="{{ $empPuesto->id_puesto }}" data-estado="{{ $empPuesto->activo }}">
                                <x-heroicon-o-pencil class="h-5 w-5" />
                            </a>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.base>
            <nav class="flex-column flex flex-wrap items-center justify-between pt-4 md:flex-row"
                aria-label="Table navigation">
                {{ $empleadosPuestos->links() }}
            </nav>
        </div>
    </div>

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
                        <x-forms.searchable-select id="empleado" label="Empleado" name="empleado" :options="$empleados" onchange="filtrarPuestos()" searchable required />
                        <div id="empleado-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <div class="mb-4">
                    <x-forms.row :columns="2">
                        <div>
                            <x-forms.select label="Entidad" id="entidad" name="entidad" :options="$entidades" :value="old('entidad')" onchange="filtrarPuestos()" required />
                            <div id="entidad-error" class="mb-4 text-sm text-red-500"></div>
                        </div>
                        <div>
                            <x-forms.select label="Puesto" id="puesto" name="puesto" :options="$puestos[old('entidad')] ?? []" :value="old('puesto')" :error="$errors->get('puesto')" required />
                            <div id="puesto-error" class="mb-4 text-sm text-red-500"></div>
                        </div>
                    </x-forms.row>
                </div>
                <div class="mb-4">
                    <x-forms.select label="Estado" id="estado" name="estado" :options="$estados" :value="old('estado')" :error="$errors->get('estado')" required />
                    <div id="estado-error" class="mb-4 text-sm text-red-500"></div>
                    @error('estado')
                        <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>
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
    const empleados = @json($empleados);
    document.getElementById('asignacion-form').addEventListener('submit', function(event) {
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
            console.log('entro');
            event.preventDefault();
            document.getElementById('general-errors').innerHTML = 'Todos los campos son requeridos';
        }
    });

    document.querySelectorAll('[data-modal-hide="static-modal"]').forEach((button) => {
        button.addEventListener('click', function() {
            updateTitle('Asignar puesto');
            document.dispatchEvent(new Event('modal:open'));
            document.getElementById('asignacion-form').action = '{{ route('empleadosPuestos.store') }}';
            document.getElementById('asignacion-form').method = 'POST';
            method = document.querySelector('[name="_method"]')
            if(method) document.getElementById('asignacion-form').removeChild(method);
            document.getElementById('search-empleado').disabled = false;
            document.getElementById('search-empleado').classList.remove('!bg-gray-300');
            document.getElementById('search-empleado').value = null;
            document.getElementById('empleado').value = null;
            document.getElementById('entidad').disabled = false;
            document.getElementById('puesto').disabled = false;
            document.getElementById('asignacion-form').reset();
            document.getElementById('general-errors').innerHTML = '';
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const entidad = this.getAttribute('data-entidad');
            const puesto = this.getAttribute('data-puesto');
            const estado = this.getAttribute('data-estado');
            const empleado = this.getAttribute('data-empleado');

            updateTitle('Editar asignación de puesto')

            document.getElementById('asignacion-form').action = `/rhu/empleados-puestos/${id}`;
            document.getElementById('asignacion-form').method = 'POST';
            document.getElementById('asignacion-form').innerHTML +=
                '<input type="hidden" name="_method" value="PUT">';

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
</script>
