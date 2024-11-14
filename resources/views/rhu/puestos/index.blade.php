@php
    $headers = [
        ['text' => 'Puesto', 'align' => 'left'],
        ['text' => 'Entidad', 'align' => 'left'], // Nueva columna
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acciones', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de Puestos" />
    </x-slot>

    <!-- Barra de filtros y botón añadir -->
    <div class="p-4 md:p-6 flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-4">
        <form method="GET" action="{{ route('puestos.index') }}"
            class="w-full md:w-auto flex flex-wrap items-center space-y-4 md:space-y-0 md:space-x-4">
            <div class="flex flex-col md:flex-row items-start md:items-center space-y-2 md:space-y-0 md:space-x-2">
                <label for="id_entidad" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Entidad</label>
                <select id="id_entidad" name="id_entidad"
                    class="w-full md:w-auto block rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm">
                    <option value="">Todos</option>
                    @foreach ($entidades as $entidad)
                        <option value="{{ $entidad->id }}"
                            {{ request('id_entidad') == $entidad->id ? 'selected' : '' }}>
                            {{ $entidad->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col md:flex-row items-start md:items-center space-y-2 md:space-y-0 md:space-x-2">
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Buscar
                    Puesto</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}"
                    class="w-full md:w-auto block rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
                    placeholder="Buscar por nombre de puesto...">
            </div>

            <button type="submit"
                class="w-full md:w-auto rounded-md bg-escarlata-ues hover:bg-red-600 px-4 py-2 text-sm font-medium text-white focus:outline-none focus:ring-4">
                Filtrar
            </button>
        </form>

        <div class="p-6">
            <x-forms.primary-button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block"
                type="button" id="add-button">
                Añadir
            </x-forms.primary-button>
        </div>
    </div>

    <!-- Tabla de puestos -->
    <div class="p-4 md:p-6 mx-auto min-w-full overflow-x-auto bg-white shadow-md sm:rounded-lg">
        <x-table.base :headers="$headers">
            <tbody>
                @forelse ($puestos as $puesto)
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
                                class="edit-button inline-flex items-center text-green-600 hover:underline dark:text-green-400"
                                data-id="{{ $puesto->id }}" data-nombre="{{ $puesto->nombre }}"
                                data-entidad="{{ $puesto->id_entidad }}" data-activo="{{ $puesto->activo }}">
                                <x-heroicon-o-pencil class="h-5 w-5" />
                                <span class="ml-1"></span>
                            </a>
                        </x-table.td>
                    </x-table.tr>
                @empty
                    <tr>
                        <td colspan="4"
                            class="px-4 py-2 md:px-6 md:py-4 text-center text-gray-500 dark:text-gray-400">No se
                            encontraron puestos</td>
                    </tr>
                @endforelse
            </tbody>
        </x-table.base>
        <nav class="flex flex-wrap items-center justify-between pt-4" aria-label="Table navigation">
            {{ $puestos->appends(request()->except('page'))->links() }}
        </nav>
    </div>
    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 id="head-text" class="text-2xl font-bold text-escarlata-ues">Añadir Puesto</h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-puesto-form" method="POST" action="{{ route('puestos.store') }}">
                @csrf
                <div class="mb-4">
                    <x-forms.input-label for="nombre" :value="__('Nombre')" />
                    <input type="text" id="nombre" name="nombre"
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-3 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm" />
                    <x-forms.input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-forms.input-label for="id_entidad" :value="__('Entidad')" />
                    <select id="id_entidad" name="id_entidad"
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm">
                        @foreach ($entidades as $entidad)
                            <option value="{{ $entidad->id }}">{{ $entidad->nombre }}</option>
                        @endforeach
                    </select>
                    <x-forms.input-error :messages="$errors->get('id_entidad')" class="mt-2" />
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
                class="rounded-lg border bg-gray-700 hover:bg-gray-600 px-7 py-2.5 text-sm font-medium text-white focus:z-10 focus:outline-none focus:ring-4">
                Cancelar
            </button>
            <button type="submit" form="add-puesto-form"
                class="ms-6 rounded-lg bg-red-700 hover:bg-red-600 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicia el modal usando el constructor de Flowbite
        const modalElement = document.getElementById('static-modal');
        const modalInstance = new Modal(modalElement);

        // Botón para abrir el modal para añadir puesto
        document.getElementById('add-button').addEventListener('click', function() {
            document.getElementById('add-puesto-form').reset();
            document.getElementById('general-errors').innerHTML = '';
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
            document.getElementById('head-text').textContent = 'Añadir Puesto';
            document.getElementById('add-puesto-form').action = "{{ route('puestos.store') }}";
            document.querySelector('input[name="_method"]')?.remove();
            modalInstance.show();
        });

        // Configurar el modal para editar un puesto
        document.querySelectorAll('.edit-button').forEach((button) => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const id = this.getAttribute('data-id');
                const nombre = this.getAttribute('data-nombre');
                const id_entidad = this.getAttribute('data-entidad');
                const activo = this.getAttribute('data-activo');

                // Ajustar el formulario para la edición
                document.getElementById('add-puesto-form').action = `/rhu/puestos/${id}`;
                document.getElementById('add-puesto-form').method = 'POST';

                if (!document.querySelector('input[name="_method"]')) {
                    const inputMethod = document.createElement('input');
                    inputMethod.setAttribute('type', 'hidden');
                    inputMethod.setAttribute('name', '_method');
                    inputMethod.setAttribute('value', 'PUT');
                    document.getElementById('add-puesto-form').appendChild(inputMethod);
                }

                document.getElementById('nombre').value = nombre;
                document.getElementById('id_entidad').value = id_entidad;
                document.getElementById('activo').value = activo;

                document.getElementById('head-text').textContent = 'Editar Puesto';
                modalInstance.show();
            });
        });
        // Cerrar modal al presionar "Cancelar"
        document.getElementById('static-modal').addEventListener('click', function() {
            modalInstance.hide();
        });
    });
</script>
