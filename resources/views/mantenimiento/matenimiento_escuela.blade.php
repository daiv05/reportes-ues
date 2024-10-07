<x-app-layout>
    <x-slot name="header">
        <div class="p-6 text-2xl font-bold text-red-900 dark:text-gray-100">
            {{ __('Mantenimiento de escuelas') }}
        </div>

    </x-slot>

    <div class="pb-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Mensaje de éxito -->
                    @if (session('message'))
                        @php
                            $alertType = session('message')['type'];
                            $alertColors = [
                                'success' => 'bg-green-100 border border-green-400 text-green-700',
                                'error' => 'bg-red-100 border border-red-400 text-red-700',
                                'warning' => 'bg-yellow-100 border border-yellow-400 text-yellow-700',
                                'info' => 'bg-blue-100 border border-blue-400 text-blue-700',
                            ];
                        @endphp
                        <div id="alert" class="{{ $alertColors[$alertType] }} px-4 py-3 rounded relative my-4"
                            role="alert">
                            <strong class="font-bold">
                                @if ($alertType == 'success')
                                    ¡Éxito!
                                @elseif($alertType == 'error')
                                    ¡Error!
                                @elseif($alertType == 'warning')
                                    ¡Advertencia!
                                @else
                                    Información
                                @endif
                            </strong>
                            <span class="block sm:inline">{{ session('message')['content'] }}</span>
                            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3 close-alert"
                                aria-label="Cerrar">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="size-5">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z"
                                        clip-rule="evenodd" />
                                </svg>

                            </button>
                        </div>
                    @endif


                    <!-- Formulario para agregar la escuela -->
                    <!-- Título con negritas para el formulario -->

                    <h2 class="text-lg font-bold py-4 text-left text-gray-800">Ingrese los datos</h2>


                    <form method="POST" action="{{ route('escuela.store') }}"
                        class="bg-white p-6 rounded-lg shadow-md">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
                            <!-- Facultad ID (Select con lista de facultades) -->
                            <div>
                                <label for="id_facultad"
                                    class="block mb-2 text-sm font-semibold text-gray-700">Facultad</label>
                                <select id="id_facultad" name="id_facultad" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="1">Ingeniería</option>
                                    <option value="2">Arquitectura</option>
                                </select>
                            </div>

                            <!-- Nombre de la Escuela -->
                            <div>
                                <label for="nombre" class="block mb-2 text-sm font-semibold text-gray-700">Nombre de
                                    la Escuela</label>
                                <input type="text" id="nombre" name="nombre" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Ingrese el nombre de la escuela">
                            </div>

                            <!-- Estado de la Escuela -->
                            <div>
                                <label for="activo"
                                    class="block mb-2 text-sm font-semibold text-gray-700">Estado</label>
                                <select id="activo" name="activo"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <!-- Botón de Crear -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 flex items-center shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="w-5 h-5 mr-2">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.25a.75.75 0 0 0-1.5 0v2.5h-2.5a.75.75 0 0 0 0 1.5h2.5v2.5a.75.75 0 0 0 1.5 0v-2.5h2.5a.75.75 0 0 0 0-1.5h-2.5v-2.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                                Crear
                            </button>
                        </div>
                    </form>


                    @if ($escuelas->isNotEmpty())
                        <div class="mt-8 overflow-x-auto">
                            <table id="search-table"
                                class="min-w-full table-auto bg-white border border-gray-300 shadow-lg">
                                <caption class="text-lg font-bold py-4 text-center text-gray-800">Detalle de escuelas
                                </caption>
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase">ID
                                        </th>
                                        <th class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase">
                                            Nombre</th>
                                        <th class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase">
                                            Estado</th>
                                        <th class="px-6 py-2 text-center text-sm font-bold text-gray-700 uppercase">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($escuelas as $escuela)
                                        <tr class="border-b">
                                            <td class="px-2 py-1 text-center text-sm font-semibold text-gray-900">
                                                {{ $escuela->id }}</td>
                                            <td class="px-2 py-1 text-center text-sm font-semibold text-gray-900">
                                                {{ $escuela->nombre }}</td>
                                            <td class="px-2 py-1 text-center text-sm font-semibold text-gray-900">
                                                {{ $escuela->activo ? 'Activo' : 'Inactivo' }}</td>
                                            <td class="px-2 py-1 text-center text-sm">
                                                <button type="button" data-modal-target="editModal{{ $escuela->id }}"
                                                    data-modal-toggle="editModal{{ $escuela->id }}"
                                                    class="text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-3 py-2 text-center mr-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" class="size-5">
                                                        <path
                                                            d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                                        <path
                                                            d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                                                    </svg>


                                                </button>
                                                <form action="{{ route('escuela.destroy', $escuela->id) }}"
                                                    method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center"
                                                        onclick="return confirm('¿Estás seguro de eliminar esta escuela?');">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="size-5">
                                                            <path fill-rule="evenodd"
                                                                d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z"
                                                                clip-rule="evenodd" />
                                                        </svg>


                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <script>
                                            if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
                                                const dataTable = new simpleDatatables.DataTable("#search-table", {
                                                    searchable: true,
                                                    sortable: false
                                                });
                                            }
                                        </script>
                                        <!-- Modal de Edición -->
                                        <div id="editModal{{ $escuela->id }}" tabindex="-1" aria-hidden="true"
                                            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto max-h-full">
                                            <div class="relative w-full max-w-2xl max-h-full">
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <!-- Modal header -->
                                                    <div
                                                        class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                            Editar Escuela
                                                        </h3>
                                                        <button type="button"
                                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                            data-modal-hide="editModal{{ $escuela->id }}">
                                                            <svg aria-hidden="true" class="w-5 h-5"
                                                                fill="currentColor" viewBox="0 0 20 20"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd"
                                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            <span class="sr-only">Cerrar modal</span>
                                                        </button>
                                                    </div>

                                                    <!-- Modal body -->

                                                    <div class="p-6 space-y-6">
                                                        <form action="{{ route('escuela.update', $escuela->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <!-- Facultad ID (Select con lista de facultades) -->
                                                            <div class="w-full">
                                                                <label for="id_facultad"
                                                                    class="block mb-2 text-sm font-medium text-gray-900">Facultad</label>
                                                                <select id="id_facultad" name="id_facultad" required
                                                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                    <option value="1"
                                                                        {{ $escuela->id_facultad == 1 ? 'selected' : '' }}>
                                                                        Ingeniería</option>
                                                                    <option value="2"
                                                                        {{ $escuela->id_facultad == 2 ? 'selected' : '' }}>
                                                                        Arquitectura</option>
                                                                </select>
                                                                </select>
                                                            </div>
                                                            <!-- Nombre de la Escuela -->
                                                            <div class="mb-4">
                                                                <label for="nombre"
                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Nombre
                                                                    de la
                                                                    Escuela</label>
                                                                <input type="text" name="nombre" id="nombre"
                                                                    value="{{ $escuela->nombre }}" required
                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                    placeholder="Ingrese el nombre de la escuela">
                                                            </div>

                                                            <!-- Estado de la Escuela -->
                                                            <div class="mb-4">
                                                                <label for="activo"
                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Estado</label>
                                                                <select name="activo" id="activo"
                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                    <option value="1"
                                                                        {{ $escuela->activo ? 'selected' : '' }}>Activo
                                                                    </option>
                                                                    <option value="0"
                                                                        {{ !$escuela->activo ? 'selected' : '' }}>
                                                                        Inactivo</option>
                                                                </select>
                                                            </div>

                                                            <!-- Modal footer -->
                                                            <div
                                                                class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                                <button data-modal-hide="editModal{{ $escuela->id }}"
                                                                    type="submit"
                                                                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Guardar
                                                                    cambios</button>
                                                                <button data-modal-hide="editModal{{ $escuela->id }}"
                                                                    type="button"
                                                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">Cancelar</button>
                                                            </div>
                                                        </form>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="mt-8 text-sm text-gray-600 dark:text-gray-400">No hay escuelas registradas.</p>
                    @endif
                </div>
            </div>
        </div>
        <script>
            document.querySelector('.close-alert').addEventListener('click', function() {
                this.closest('div[role="alert"]').style.display = 'none';
            });
        </script>
    </div>
</x-app-layout>
