<x-app-layout>
    <!-- Mensaje de éxito -->
    <x-slot name="header">
        <div class="p-6 text-2xl font-bold text-red-900 dark:text-gray-100">
            @if (session('message'))
                <x-alert :type="session('message')['type']" :message="session('message')['content']" />
            @endif
            {{ __('Escuela') }}
        </div>
    </x-slot>




    <!-- Boton agregar -->
    <div class="pb-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6">
                    <x-primary-button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block"
                        type="button">
                        Añadir
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>

    <!-- tabla de datos -->
    <div class="flex flex-col justify-center items-center overflow-x-auto shadow-md sm:rounded-lg w-[64%] mx-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Nombre</th>
                    <th scope="col" class="px-6 py-3">Facultad</th>
                    <th scope="col" class="px-6 py-3">Activo</th>
                    <th scope="col" class="px-6 py-3">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($escuelas as $escuela)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $escuela->nombre }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $escuela->facultades->nombre }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $escuela->activo ? 'Sí' : 'No' }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="#"
                                class="font-medium text-green-600 dark:text-green-400 hover:underline edit-button"
                                data-id="{{ $escuela->id }}" data-nombre="{{ $escuela->nombre }}"
                                data-facultad="{{ $escuela->facultades->id }}" data-activo="{{ $escuela->activo }}">
                                <x-heroicon-o-pencil class="w-5 h-5" />
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4"
            aria-label="Table navigation">
            {{ $escuelas->links() }}
        </nav>
    </div>
    <!-- Modal agregar-->
    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 class="text-2xl font-bold text-escarlata-ues">
                Añadir escuela
            </h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-escuela-form" method="POST" action="{{ route('escuela.store') }}">
                @csrf
                <div id="general-errors" class="text-red-500 text-sm mb-4"></div>
                <div class="mb-4">
                    <label for="id_facultad"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facultad</label>
                    <select id="id_facultad" name="id_facultad"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md dark:bg-gray-700 dark:text-gray-300">
                        @foreach ($facultades as $facultad)
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
            <button type="submit" form="add-escuela-form"
                class="bg-red-700 ms-6 text-white focus:ring-4 focus:outline-none  font-medium rounded-lg text-sm px-8 py-2.5 text-center">
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>
<script>
    document.getElementById('add-escuela-form').addEventListener('submit', function(event) {
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
        button.addEventListener('click', function() {
            document.getElementById('add-escuela-form').reset();
            document.getElementById('general-errors').innerHTML = '';
            document.querySelectorAll('.text-red-500').forEach(error => error.innerHTML = '');
        });
    });

    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const facultad = this.getAttribute('data-facultad');
            const activo = this.getAttribute('data-activo');

            document.getElementById('add-escuela-form').action = `/escuela/${id}`;
            document.getElementById('add-escuela-form').method = 'POST';
            document.getElementById('add-escuela-form').innerHTML +=
                '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('nombre').value = nombre;
            document.getElementById('id_facultad').value = facultad;
            document.getElementById('activo').value = activo;

            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });
</script>
<script>
    function editarDepartamento(depa) {
        document.getElementById('static-modal-update')
    }
</script>
