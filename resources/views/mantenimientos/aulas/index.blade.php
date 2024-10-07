<x-app-layout>
    <x-slot name="header">
        <div class="p-6 text-2xl font-bold text-red-900 dark:text-gray-100">
            {{ __('Aulas') }}
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6">
                    <x-primary-button data-modal-target="static-modal" data-modal-toggle="static-modal"
                                      class="block"
                                      type="button">
                        Añadir
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>

    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 class="text-2xl font-bold text-escarlata-ues">
                Añadir Aula
            </h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-aula-form" method="POST" action="{{ route('aulas.store') }}">
                @csrf
                <div id="general-errors" class="text-red-500 text-sm mb-4"></div>
                <div class="mb-4">
                    <label for="id_facultad"
                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facultad</label>
                    <select id="id_facultad" name="id_facultad"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md dark:bg-gray-700 dark:text-gray-300">
                        @foreach($facultades as $facultad)
                            <option value="{{ $facultad->id }}">{{ $facultad->nombre }}</option>
                        @endforeach
                    </select>
                    @error('id_facultad')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="nombre"
                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                    <input type="text" id="nombre" name="nombre"
                           class="mt-1 block w-full pl-3 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm dark:bg-gray-700 dark:text-gray-300">
                    @error('nombre')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="activo"
                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">Activo</label>
                    <select id="activo" name="activo"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-red-500 focus:border-escarlata-ues sm:text-sm rounded-md dark:bg-gray-700 dark:text-gray-300">
                        <option value="1">Sí</option>
                        <option value="0">No</option>
                    </select>
                    @error('activo')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </form>
        </x-slot>
        <x-slot name="footer">
            <button data-modal-hide="static-modal" type="button"
                    class="bg-gray-700 text-white py-2.5 px-7 text-sm font-medium focus:outline-none rounded-lg border focus:z-10 focus:ring-4">
                Cancelar
            </button>
            <button type="submit" form="add-aula-form"
                    class="bg-red-700 ms-6 text-white focus:ring-4 focus:outline-none  font-medium rounded-lg text-sm px-8 py-2.5 text-center">
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>
<script>
    document.getElementById('add-aula-form').addEventListener('submit', function (event) {
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

    document.querySelectorAll('[data-modal-hide="static-modal"]').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('add-aula-form').reset();
            document.getElementById('general-errors').innerHTML = '';
            document.querySelectorAll('.text-red-500').forEach(error => error.innerHTML = '');
        });
    });
</script>
