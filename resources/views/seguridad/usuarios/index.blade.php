@php
    $headers = [
        ['text' => 'Usuario', 'align' => 'left'],
        ['text' => 'Email', 'align' => 'left'],
        ['text' => 'Roles', 'align' => 'left'],
        ['text' => 'Acciones', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de Roles" />
    </x-slot>

    <div>
        <div class="p-6">
            <x-forms.primary-button
                data-modal-target="static-modal"
                data-modal-toggle="static-modal"
                class="block"
                type="button"
                id="add-button"
            >
                Añadir
            </x-forms.primary-button>
        </div>
        <div class="mx-auto mb-6 flex flex-col items-center justify-center overflow-x-auto sm:rounded-lg">
            <x-table.base :headers="$headers">
                @foreach ($usuarios as $usuario)
                    <x-table.tr>
                        <x-table.td>
                            {{ $usuario->carnet }}
                        </x-table.td>
                        <x-table.td>
                            {{ $usuario->email }}
                        </x-table.td>
                        <x-table.td>
                            {{ implode(', ', $usuario->roles->pluck('name')->toArray()) }}
                        </x-table.td>
                        <x-table.td>
                            <a
                                href="#"
                                class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                data-id="{{ $usuario->id }}"
                                data-carnet="{{ $usuario->carnet }}"
                                data-email="{{ $usuario->email }}"
                                data-rol=" {{ implode(', ', $usuario->roles->pluck('name')->toArray()) }}"
                            >
                                <x-heroicon-o-pencil class="h-5 w-5" />
                            </a>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.base>
            <nav
                class="flex-column flex flex-wrap items-center justify-between pt-4 md:flex-row"
                aria-label="Table navigation"
            >
                {{ $usuarios->links() }}
            </nav>
        </div>
    </div>

    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 id="head-text" class="text-2xl font-bold text-escarlata-ues">Añadir Uusario</h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-roles-form" method="POST" action="{{ route('roles.store') }}">
                @csrf
                <div class="mb-4">
                    <x-forms.input-label for="nombre" :value="__('Nombre')" />
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="mt-1 block w-full rounded-md border border-gray-300 py-2 pl-3 pr-3 shadow-sm focus:border-red-500 focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
                    />
                    <x-forms.input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-forms.input-label for="activo" :value="__('Estado')" />
                    <select
                        id="activo"
                        name="activo"
                        class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-escarlata-ues focus:outline-none focus:ring-red-500 dark:bg-gray-700 dark:text-gray-300 sm:text-sm"
                    >
                        <option value="1">ACTIVO</option>
                        <option value="0">INACTIVO</option>
                    </select>
                    <x-forms.input-error :messages="$errors->get('activo')" class="mt-2" />
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
                form="add-roles-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4"
            >
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>
<script>
    document.getElementById('add-roles-form').addEventListener('submit', function (event) {
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
            document.getElementById('add-roles-form').reset();
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
        });
    });

    document.getElementById('add-button').addEventListener('click', function (event) {
        console.log('fdadada');
        document.getElementById('head-text').innerHTML = 'Agregar Rol';
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const activo = this.getAttribute('data-activo');

            document.getElementById('add-roles-form').action = `/seguridad/roles/${id}`;
            document.getElementById('add-roles-form').method = 'POST';
            document.getElementById('add-roles-form').innerHTML +=
                '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('name').value = name;
            document.getElementById('activo').value = activo;
            document.getElementById('head-text').textContent = 'Editar rol';
            console.log(document.getElementById('head-text'), 'document.getElementById');

            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });
</script>
