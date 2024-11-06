@php
    $headers = [
      ['text' => 'Nombre', 'align' => 'left'],
      ['text' => 'Facultad', 'align' => 'left'],
      ['text' => 'Estado', 'align' => 'center'],
      ['text' => 'Acciones', 'align' => 'center'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de Escuelas" />
    </x-slot>

    <!-- Boton agregar -->
    <div>
        <div class="flex flex-col space-y-4 pb-4 sm:flex-row sm:space-y-0 sm:space-x-4">
            <x-forms.primary-button
                data-modal-target="static-modal"
                data-modal-toggle="static-modal"
                class="block"
                type="button"
            >
                Añadir
            </x-forms.primary-button>
        </div>
        <x-table.base :headers="$headers">
                @foreach ($escuelas as $escuela)
                <x-table.tr>
                    <x-table.td>{{ $escuela->nombre }}</x-table.td>
                    <x-table.td>{{ $escuela->facultades->nombre }}</x-table.td>
                    <x-table.td><x-status.is-active :active="$escuela->activo" /></x-table.td>
                    <x-table.td>
                        <a
                            href="#"
                            class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                            data-id="{{ $escuela->id }}"
                            data-nombre="{{ $escuela->nombre }}"
                            data-facultad="{{ $escuela->facultades->id }}"
                            data-activo="{{ $escuela->activo }}"
                        >
                            <x-heroicon-o-pencil class="h-5 w-5" />
                        </a>
                    </x-table.td>
                </x-table.tr>
                @endforeach
        </x-table.base>
        <nav
            class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row"
            aria-label="Table navigation"
        >
            {{ $escuelas->links() }}
        </nav>
    </div>

    <!-- Modal agregar-->
    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 class="text-2xl font-bold text-escarlata-ues">Añadir escuela</h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-escuela-form" method="POST" action="{{ route('escuela.store') }}">
                @csrf
                <div id="general-errors" class="mb-4 text-sm text-red-500"></div>
                <div class="mb-4">
                    <label for="id_facultad" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Facultad
                    </label>
                    <select
                        id="id_facultad"
                        name="id_facultad"
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
                    >
                        @foreach ($facultades as $facultad)
                            <option value="{{ $facultad->id }}">{{ $facultad->nombre }}</option>
                        @endforeach
                    </select>
                    @error('id_facultad')
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
                form="add-escuela-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4"
            >
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>
<script>
    document.getElementById('add-escuela-form').addEventListener('submit', function (event) {
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
            document.getElementById('add-escuela-form').reset();
            document.getElementById('general-errors').innerHTML = '';
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const facultad = this.getAttribute('data-facultad');
            const activo = this.getAttribute('data-activo');

            document.getElementById('add-escuela-form').action = `/mantenimientos/escuela/${id}`;
            document.getElementById('add-escuela-form').method = 'POST';
            document.getElementById('add-escuela-form').innerHTML += '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('nombre').value = nombre;
            document.getElementById('id_facultad').value = facultad;
            document.getElementById('activo').value = activo;

            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });
</script>
