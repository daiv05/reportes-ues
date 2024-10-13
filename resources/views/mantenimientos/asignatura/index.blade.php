<x-app-layout>
    <!-- Mensaje de éxito -->
    @if (session('message'))
        <x-alert :type="session('message')['type']" :message="session('message')['content']" />
    @endif

    <x-slot name="header">
        <x-header.simple titulo="Gestión de Asignaturas" />
    </x-slot>

    <div>
        <div class="p-6">
            <x-forms.primary-button
                data-modal-target="static-modal"
                data-modal-toggle="static-modal"
                class="block"
                type="button"
            >
                Añadir
            </x-forms.primary-button>
        </div>
        <!-- tabla de datos -->
        <div class="mx-auto flex flex-col items-center justify-center overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400 rtl:text-right">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nombre</th>
                        <th scope="col" class="px-6 py-3">Escuela</th>
                        <th scope="col" class="px-6 py-3">Activo</th>
                        <th scope="col" class="px-6 py-3">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asignaturas as $asignatura)
                        <tr
                            class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600"
                        >
                            <th
                                scope="row"
                                class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white"
                            >
                                {{ $asignatura->nombre }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $asignatura->escuela->nombre }}
                            </td>
                            <td class="px-6 py-4">
                                <x-status.is-active :active="$asignatura->activo" />
                            </td>
                            <td class="px-6 py-4">
                                <a
                                    href="#"
                                    class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                    data-id="{{ $asignatura->id }}"
                                    data-nombre="{{ $asignatura->nombre }}"
                                    data-escuela="{{ $asignatura->escuela->id }}"
                                    data-activo="{{ $asignatura->activo }}"
                                >
                                    <x-heroicon-o-pencil class="h-5 w-5" />
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <nav
                class="flex-column flex flex-wrap items-center justify-between pt-4 md:flex-row"
                aria-label="Table navigation"
            >
                {{ $asignaturas->links() }}
            </nav>
        </div>
    </div>

    <!-- Modal agregar-->
    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 class="text-2xl font-bold text-escarlata-ues">Añadir asignatura</h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-asignatura-form" method="POST" action="{{ route('asignatura.store') }}">
                @csrf
                <div id="general-errors" class="mb-4 text-sm text-red-500"></div>
                <div class="mb-4">
                    <label for="id_escuela" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Escuela
                    </label>
                    <select
                        id="id_escuela"
                        name="id_escuela"
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
                    >
                        @foreach ($escuelas as $escuela)
                            <option value="{{ $escuela->id }}">{{ $escuela->nombre }}</option>
                        @endforeach
                    </select>
                    @error('id_escuela')
                        <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nombre
                    </label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        class="mt-1 block w-full rounded-md border border-gray-300 py-2 pl-3 pr-3 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
                    />
                    @error('nombre')
                        <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="activo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Activo
                    </label>
                    <select
                        id="activo"
                        name="activo"
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-escarlata-ues focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
                    >
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                    @error('activo')
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
                form="add-asignatura-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4"
            >
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>
<script>
    document.getElementById('add-asignatura-form').addEventListener('submit', function (event) {
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

        if (hasErrors) {
            event.preventDefault();
            document.getElementById('general-errors').innerHTML = errorMessage;
        }
    });

    document.querySelectorAll('[data-modal-hide="static-modal"]').forEach((button) => {
        button.addEventListener('click', function () {
            document.getElementById('add-asignatura-form').reset();
            document.getElementById('general-errors').innerHTML = '';
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const escuela = this.getAttribute('data-escuela');
            const activo = this.getAttribute('data-activo');

            document.getElementById('add-asignatura-form').action = `/mantenimientos/asignatura/${id}`;
            document.getElementById('add-asignatura-form').method = 'POST';
            document.getElementById('add-asignatura-form').innerHTML +=
                '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('nombre').value = nombre;
            document.getElementById('id_escuela').value = escuela;
            document.getElementById('activo').value = activo;

            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });
</script>
<script>
    function editarDepartamento(depa) {
        document.getElementById('static-modal-update');
    }
</script>
