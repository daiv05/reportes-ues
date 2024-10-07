<x-app-layout>
    <x-slot name="header">
        <div class="p-6 text-2xl font-bold text-red-900 dark:text-gray-100">
            {{ __('Tipos de actividad') }}
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Formulario para agregar tipo de actividades -->
                    <form method="POST" action="{{ route('tipo-actividades.store') }}">
                        @csrf
                        <div class="flex items-center space-x-4">
                            <!-- Nombre de la Actividad -->
                            <div class="w-full">
                                <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900">Nombre de la
                                    Actividad</label>
                                <input type="text" id="nombre" name="nombre" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Ingrese el nombre del tipo de actividad">
                            </div>

                            <!-- Estado de la Actividad -->
                            <div class="w-full">
                                <label for="activo"
                                    class="block mb-2 text-sm font-medium text-gray-900">Estado</label>
                                <select id="activo" name="activo"
                                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>

                            <!-- Botón de Crear -->
                            <div class="flex items-center">
                                <button type="submit"
                                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5 mr-2">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.25a.75.75 0 0 0-1.5 0v2.5h-2.5a.75.75 0 0 0 0 1.5h2.5v2.5a.75.75 0 0 0 1.5 0v-2.5h2.5a.75.75 0 0 0 0-1.5h-2.5v-2.5Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Crear
                                </button>
                            </div>
                        </div>
                    </form>


                    <!-- Tabla de tipos de actividades -->
                    @if ($tiposActividades->isNotEmpty())
                        <div class="mt-8">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-gray-700">
                                        <th
                                            class="px-4 py-2 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            ID</th>
                                        <th
                                            class="px-4 py-2 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            Nombre</th>
                                        <th
                                            class="px-4 py-2 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            Estado</th>
                                        <th
                                            class="px-4 py-2 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tiposActividades as $tipo)
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $tipo->id }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $tipo->nombre }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $tipo->activo ? 'Activo' : 'Inactivo' }}
                                            </td>
                                            <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">
                                                <!-- Botón Editar -->
                                                <button type="button" data-modal-target="editModal{{ $tipo->id }}"
                                                    data-modal-toggle="editModal{{ $tipo->id }}"
                                                    class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-3 py-2 text-center mr-2">
                                                    Editar
                                                </button>
                                                <!-- Botón Eliminar -->
                                                <form action="{{ route('actividad-tipo.destroy', $tipo->id) }}"
                                                    method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center"
                                                        onclick="return confirm('¿Estás seguro de eliminar este tipo de actividad?');">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Modal de Edición -->
                                        <div id="editModal{{ $tipo->id }}" tabindex="-1" aria-hidden="true"
                                            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto max-h-full">
                                            <div class="relative w-full max-w-2xl max-h-full">
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <!-- Modal header -->
                                                    <div
                                                        class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                            Editar Tipo de Actividad
                                                        </h3>
                                                        <button type="button"
                                                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                            data-modal-hide="editModal{{ $tipo->id }}">
                                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"
                                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd"
                                                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg>
                                                            <span class="sr-only">Cerrar modal</span>
                                                        </button>
                                                    </div>

                                                    <!-- Modal body -->
                                                    <div class="p-6 space-y-6">
                                                        <form action="{{ route('actividad-tipo.update', $tipo->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="mb-4">
                                                                <label for="nombre"
                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Nombre
                                                                    de la Actividad</label>
                                                                <input type="text" name="nombre" id="nombre"
                                                                    value="{{ $tipo->nombre }}" required
                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                            </div>

                                                            <div class="mb-4">
                                                                <label for="activo"
                                                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Estado</label>
                                                                <select name="activo" id="activo"
                                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                                    <option value="1"
                                                                        {{ $tipo->activo ? 'selected' : '' }}>Activo
                                                                    </option>
                                                                    <option value="0"
                                                                        {{ !$tipo->activo ? 'selected' : '' }}>Inactivo
                                                                    </option>
                                                                </select>
                                                            </div>

                                                            <!-- Modal footer -->
                                                            <div
                                                                class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                                <button data-modal-hide="editModal{{ $tipo->id }}"
                                                                    type="submit"
                                                                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Guardar
                                                                    cambios</button>
                                                                <button data-modal-hide="editModal{{ $tipo->id }}"
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
                        <p class="mt-8 text-sm text-gray-600 dark:text-gray-400">No hay tipos de actividades
                            registrados.</p>
                    @endif



                </div>
            </div>
        </div>
    </div>

</x-app-layout>
