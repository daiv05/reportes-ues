@php
    $headers = [
        ['text' => 'Nombre', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acción', 'align' => 'left'],
    ];
@endphp
<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de tipos de bienes"/>
        <div class="p-6">
            @canany(['TIPOS_BIENES_CREAR'])
            <x-forms.primary-button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block"
                                    type="button">
                Añadir
            </x-forms.primary-button>
            @endcanany
        </div>
    </x-slot>
    <x-container>
        {{-- Filtros --}}
        <div
            class="flex-col flex flex-wrap items-center justify-between space-y-4 pb-4 sm:flex-row sm:space-y-0 w-full">
            <form action="{{ route('tiposBienes.index') }}" method="GET"
                  class="flex-row flex flex-wrap items-center space-x-8 mt-4 w-full">
                <div class="flex w-full flex-col md:w-2/6 px-4 md:px-0">
                    <x-forms.row :columns="1">
                        <x-forms.field
                            id="nombre"
                            label="Nombre"
                            name="nombre-filter"
                            :value="request('nombre-filter')"
                        />
                    </x-forms.row>
                </div>
                <div class="flex flex-wrap space-x-4">
                    <button type="submit"
                            class="align-middle rounded-full inline-flex items-center px-3 py-3 border border-transparent shadow-sm text-sm font-medium text-white bg-escarlata-ues hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                        </svg>
                    </button>

                    <button type="reset"
                            class="align-middle rounded-full inline-flex items-center px-3 py-3 shadow-sm text-sm font-medium bg-white border border-gray-500 text-gray-500 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                            onclick="window.location.href='{{ route('tiposBienes.index') }}';">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        {{-- TABLA --}}
        <div class="mx-auto mb-6 flex flex-col overflow-x-auto sm:rounded-lg">
            <x-table.base :headers="$headers">
                @foreach ($tiposBienes as $tipoBien)
                    <x-table.tr>
                        <x-table.td>{{ $tipoBien->nombre }}</x-table.td>
                        <x-table.td justify="center">
                            <x-status.is-active :active="$tipoBien->activo"/>
                        </x-table.td>
                        <x-table.td>
                            @canany(['TIPOS_BIENES_EDITAR'])
                            <a href="#"
                               class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                               data-id="{{ $tipoBien->id }}" data-nombre="{{ $tipoBien->nombre }}"
                               data-activo="{{ $tipoBien->activo }}">
                                <x-heroicon-o-pencil class="h-5 w-5"/>
                            </a>
                            @endcanany
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.base>
        </div>

        <nav class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row"
             aria-label="Table navigation">
            {{ $tiposBienes->links() }}
        </nav>
    </x-container>
    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 id="modal-title" class="text-2xl font-bold text-escarlata-ues">Añadir Tipo de Bien</h3>
        </x-slot>
        <x-slot name="body">
            <form id="tipo-bien-form" method="POST" action="{{ route('tiposBienes.store') }}">
                @csrf
                <div id="general-errors" class="mb-4 text-sm text-red-500"></div>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.field id="nombre" label="Nombre" name="nombre" :value="old('nombre')"
                                       :error="$errors->get('nombre')" required/>
                        <div id="nombre-error" class="text-sm text-red-500"></div>
                    </div>
                    <div>
                        <x-forms.select label="Estado" id="activo" name="activo"
                                        :options="['1' => 'ACTIVO', '0' => 'INACTIVO']" :value="old('activo', '1')"
                                        :error="$errors->get('activo')" required/>
                        <div id="estado-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
            </form>
        </x-slot>
        <x-slot name="footer">
            <button data-modal-hide="static-modal" type="button"
                    class="rounded-lg border bg-gray-700 px-7 py-2.5 text-sm font-medium text-white focus:z-10 focus:outline-none focus:ring-4">
                Cancelar
            </button>
            <button type="submit" form="tipo-bien-form"
                    class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>
<script>
    document.getElementById('tipo-bien-form').addEventListener('submit', function (event) {
        const nombreField = document.getElementById('nombre');
        const estadoField = document.getElementById('activo');

        let hasErrors = false;

        document.getElementById('general-errors').innerHTML = '';
        document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));

        if (!nombreField.value.trim()) {
            hasErrors = true;
            document.getElementById('nombre-error').innerHTML = 'El campo Nombre es obligatorio';
        }

        if (!estadoField.value.trim()) {
            hasErrors = true;
            document.getElementById('estado-error').innerHTML = 'El campo Estado es obligatorio';
        }

        if (hasErrors) {
            event.preventDefault();
            document.getElementById('general-errors').innerHTML = 'Todos los campos son requeridos';
        }
    });

    document.querySelectorAll('[data-modal-hide="static-modal"]').forEach((button) => {
        button.addEventListener('click', function () {
            updateModalTitle('Añadir Tipo de Bien');

            resetForm();

            document.getElementById('tipo-bien-form').method = 'POST';
            document.getElementById('tipo-bien-form').action = "{{ route('tiposBienes.store') }}";

            document.querySelectorAll('input[name="_method"]').forEach((input) => input.remove());
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const activo = this.getAttribute('data-activo');

            updateModalTitle('Editar Tipo de Bien');

            document.getElementById('tipo-bien-form').action = `/mantenimientos/tipos-bienes/${id}`;
            document.getElementById('tipo-bien-form').method = 'POST';

            if (!document.querySelector('input[name="_method"]')) {
                document.getElementById('tipo-bien-form').innerHTML += '<input type="hidden" name="_method" value="PUT">';
            }

            document.getElementById('nombre').value = nombre;
            document.getElementById('activo').value = activo;

            // Abrir el modal
            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });

    function updateModalTitle(title) {
        document.getElementById('modal-title').textContent = title;
    }

    function resetForm() {
        document.getElementById('tipo-bien-form').reset();
        document.getElementById('general-errors').innerHTML = '';

        document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));

        document.querySelectorAll('select').forEach((select) => {
            select.selectedIndex = 0;
        });
    }
</script>
