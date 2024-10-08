<x-app-layout>
    <x-slot name="header">
        <div class="p-6 text-2xl font-bold text-red-900 dark:text-gray-100">
            {{ __('Gestión de Departamentos') }}
        </div>
    </x-slot>

    @php
        $departamentoSeleccionado = [
            'nombre' => '',
            'descripcion' => '',
            'activo' => true,
        ]
    @endphp

    <div class="pb-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6">
                    <x-primary-button
                        data-modal-target="static-modal"
                        data-modal-toggle="static-modal"
                        class="block"
                        type="button"
                    >
                        Añadir
                    </x-primary-button>
                </div>
                <div class="mx-auto max-w-[85%] flex flex-col items-center justify-center overflow-x-auto sm:rounded-lg mb-16">
                    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400 rtl:text-right shadow-md">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nombre</th>
                                <th scope="col" class="px-6 py-3">Descripcion</th>
                                <th scope="col" class="px-6 py-3">Estado</th>
                                <th scope="col" class="px-6 py-3">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departamentos as $depa)
                                <tr
                                    class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600"
                                >
                                    <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $depa->nombre }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $depa->descripcion }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $depa->activo ? 'ACTIVO' : 'INACTIVO' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a
                                            href="#"
                                            onclick="editarDepartamento($depa)"
                                            class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
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
                        {{ $departamentos->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <x-form-modal id="static-modal-add">
        <x-slot name="header">
            <h3 class="text-2xl font-bold text-escarlata-ues">Añadir Departamento</h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-departamentos-form" method="POST" action="{{ route('departamentos.store') }}">
                @csrf
                <div class="mb-4">
                    <x-input-label for="nombre" :value="__('Nombre')" />
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        :value="old('nombre')"
                        class="mt-1 block w-full rounded-md border border-gray-300 py-2 pl-3 pr-3 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
                    />
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="descripcion" :value="__('Descripcion')" />
                    <textarea
                        id="descripcion"
                        name="descripcion"
                        rows="4"
                        :value="old('descripcion')"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        placeholder="Describa brevemente las funciones..."
                    ></textarea>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="activo" :value="__('Activo')" />
                    <select
                        id="activo"
                        name="activo"
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-escarlata-ues focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
                    >
                        <option value="1">ACTIVO</option>
                        <option value="0">INACTIVO</option>
                    </select>
                    <x-input-error :messages="$errors->get('activo')" class="mt-2" />
                </div>
            </form>
        </x-slot>
        <x-slot name="footer">
            <button
                data-modal-hide="static-modal-add"
                type="button"
                class="rounded-lg border bg-gray-700 px-7 py-2.5 text-sm font-medium text-white focus:z-10 focus:outline-none focus:ring-4"
            >
                Cancelar
            </button>
            <button
                type="submit"
                form="add-departamentos-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4"
            >
                Guardar
            </button>
        </x-slot>
    </x-form-modal>

    {{-- <x-form-modal id="static-modal-update">
        <x-slot name="header">
            <h3 class="text-2xl font-bold text-escarlata-ues">Añadir Departamento</h3>
        </x-slot>
        <x-slot name="body">
            <form id="update-departamentos-form" method="POST" action="{{ route('departamentos.update') }}">
                @method('PUT')
                @csrf
                <div class="mb-4">
                    <x-input-label for="nombre" :value="__('Nombre')" />
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        :value="old('nombre')"
                        class="mt-1 block w-full rounded-md border border-gray-300 py-2 pl-3 pr-3 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
                    />
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="descripcion" :value="__('Descripcion')" />
                    <textarea
                        id="descripcion"
                        name="descripcion"
                        rows="4"
                        :value="old('descripcion')"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                        placeholder="Describa brevemente las funciones..."
                    ></textarea>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="activo" :value="__('Activo')" />
                    <select
                        id="activo"
                        name="activo"
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-escarlata-ues focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
                    >
                        <option value="1">ACTIVO</option>
                        <option value="0">INACTIVO</option>
                    </select>
                    <x-input-error :messages="$errors->get('activo')" class="mt-2" />
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
                form="add-departamentos-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4"
            >
                Guardar
            </button>
        </x-slot>
    </x-form-modal> --}}
</x-app-layout>
<script>
    function editarDepartamento(depa) {
        document.getElementById('static-modal-update')
    }
</script>
