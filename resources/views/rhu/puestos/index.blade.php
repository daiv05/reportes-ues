<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de Puestos" />
    </x-slot>

    <!-- Barra de filtros y botón añadir -->
    <div class="p-4 md:p-6 flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-4">
        <form method="GET" action="{{ route('puestos.index') }}" class="w-full md:w-auto flex flex-wrap items-center space-y-4 md:space-y-0 md:space-x-4">
            <div class="flex flex-col md:flex-row items-start md:items-center space-y-2 md:space-y-0 md:space-x-2">
                <label for="id_departamento" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departamento</label>
                <select id="id_departamento" name="id_departamento"
                        class="w-full md:w-auto block rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm">
                    <option value="">Todos</option>
                    @foreach ($departamentos as $departamento)
                        <option value="{{ $departamento->id }}" {{ request('id_departamento') == $departamento->id ? 'selected' : '' }}>
                            {{ $departamento->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col md:flex-row items-start md:items-center space-y-2 md:space-y-0 md:space-x-2">
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Buscar Puesto</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}"
                       class="w-full md:w-auto block rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
                       placeholder="Buscar por nombre de puesto...">
            </div>

            <button type="submit"
                    class="w-full md:w-auto rounded-md bg-escarlata-ues hover:bg-red-600 px-4 py-2 text-sm font-medium text-white focus:outline-none focus:ring-4">
                Filtrar
            </button>
        </form>

        <!-- Botón Añadir -->
        <button id="add-button" class="w-full md:w-auto rounded-md bg-red-700 hover:bg-red-600 px-6 py-2 text-sm font-medium text-white focus:outline-none focus:ring-4">
            Añadir Puesto
        </button>
    </div>

    <!-- Tabla de puestos -->
    <div class="p-4 md:p-6 mx-auto min-w-full overflow-x-auto bg-white shadow-md sm:rounded-lg">
        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
            <thead class="bg-gray-100 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-2 md:px-6 md:py-3">Nombre</th>
                    <th scope="col" class="px-4 py-2 md:px-6 md:py-3">Departamento</th>
                    <th scope="col" class="px-4 py-2 md:px-6 md:py-3">Estado</th>
                    <th scope="col" class="px-4 py-2 md:px-6 md:py-3">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($puestos as $puesto)
                    <tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                        <td class="whitespace-nowrap px-4 py-2 md:px-6 md:py-4 font-medium text-gray-900 dark:text-white">
                            {{ $puesto->nombre }}
                        </td>
                        <td class="px-4 py-2 md:px-6 md:py-4">
                            {{ $puesto->departamento->nombre }}
                        </td>
                        <td class="px-4 py-2 md:px-6 md:py-4">
                            <x-status.is-active :active="$puesto->activo" />
                        </td>
                        <td class="px-4 py-2 md:px-6 md:py-4">
                            <a href="#" class="edit-button inline-flex items-center text-green-600 hover:underline dark:text-green-400"
                               data-id="{{ $puesto->id }}" data-nombre="{{ $puesto->nombre }}"
                               data-departamento="{{ $puesto->id_departamento }}" data-activo="{{ $puesto->activo }}">
                                <x-heroicon-o-pencil class="h-5 w-5" />
                                <span class="ml-1">Editar</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 md:px-6 md:py-4 text-center text-gray-500 dark:text-gray-400">No se encontraron puestos</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <nav class="flex flex-wrap items-center justify-between pt-4" aria-label="Table navigation">
            {{ $puestos->appends(request()->except('page'))->links() }}
        </nav>
    </div>
</x-app-layout>




<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inicia el modal usando el constructor de Flowbite
        const modalElement = document.getElementById('static-modal');
        const modalInstance = new Modal(modalElement);

        // Botón para abrir el modal para añadir puesto
        document.getElementById('add-button').addEventListener('click', function () {
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
            button.addEventListener('click', function (event) {
                event.preventDefault();
                const id = this.getAttribute('data-id');
                const nombre = this.getAttribute('data-nombre');
                const id_departamento = this.getAttribute('data-departamento');
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
                document.getElementById('id_departamento').value = id_departamento;
                document.getElementById('activo').value = activo;

                document.getElementById('head-text').textContent = 'Editar Puesto';
                modalInstance.show();
            });
        });

        // Cerrar modal al presionar "Cancelar"
        document.getElementById('close-modal').addEventListener('click', function () {
            modalInstance.hide();
        });
    });
</script>
