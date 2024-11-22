@php
    $headers = [
        ['text' => 'Año', 'align' => 'center'],
        ['text' => 'Tipo de Ciclo', 'align' => 'center'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acción', 'align' => 'center'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de Ciclos" />
        <div class="p-6">
            <x-forms.primary-button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block"
                type="button" id="add-button">
                Añadir Ciclo
            </x-forms.primary-button>
        </div>
    </x-slot>

    <x-container>
        <div class="mx-auto mb-8 flex flex-col items-center justify-center overflow-x-auto sm:rounded-lg">
            <x-table.base :headers="$headers">
                @foreach ($ciclos as $ciclo)
                    <x-table.tr>
                        <x-table.td justify="center">
                            {{ $ciclo->anio }}
                        </x-table.td>
                        <x-table.td justify="center">
                            {{ $ciclo->tipoCiclo->nombre }}
                        </x-table.td>
                        <x-table.td justify="center">
                            <x-status.is-active :active="$ciclo->activo" />
                        </x-table.td>
                        <x-table.td justify="center">
                            <a href="#"
                                class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                data-id="{{ $ciclo->id }}" data-anio="{{ $ciclo->anio }}"
                                data-tipo_ciclo="{{ $ciclo->id_tipo_ciclo }}" data-estado="{{ $ciclo->activo }}">
                                <x-heroicon-o-pencil class="h-5 w-5" />
                            </a>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.base>
            <nav class="flex-column flex flex-wrap items-center justify-between pt-4 md:flex-row"
                aria-label="Table navigation">
                {{ $ciclos->links() }}
            </nav>
        </div>
    </x-container>

    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 id="modal-title" class="text-2xl font-bold text-escarlata-ues">Añadir Ciclo</h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-ciclo-form" method="POST" action="{{ route('ciclos.store') }}">
                @csrf
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.field label="Año" name="anio" :value="old('anio')" :error="$errors->get('anio')" required />
                        <div id="anio-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.select label="Tipo de Ciclo" id="id_tipo_ciclo" name="id_tipo_ciclo" :options="$tiposCiclos" :value="old('id_tipo_ciclo')" :error="$errors->get('id_tipo_ciclo')" required />
                        <div id="tipo-ciclo-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.select label="Estado" id="activo" name="activo" :options="$estados" :selected="1" :error="$errors->get('activo')" required />
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
            <button type="submit" form="add-ciclo-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>

<script>
    document.getElementById('add-ciclo-form').addEventListener('submit', function(event) {
        const anio = document.getElementById('anio').value.trim();
        const tipoCiclo = document.getElementById('id_tipo_ciclo').value.trim();
        const estado = document.getElementById('activo').value.trim();

        let hasErrors = false;

        if (!anio) {
            hasErrors = true;
            document.getElementById('anio-error').innerHTML = 'El campo año es obligatorio';
        } else {
            const anioActual = new Date().getFullYear();
            // Validar que el año se pueda registrar al menos un año antes del valor del input
            if (anio < anioActual - 1) {
                hasErrors = true;
                document.getElementById('anio-error').innerHTML = 'El año no puede ser menor a ' + (anioActual - 1);
            }
        }

        if (!tipoCiclo) {
            hasErrors = true;
            document.getElementById('tipo-ciclo-error').innerHTML = 'El campo tipo ciclo es obligatorio';
        }

        if (!estado) {
            hasErrors = true;
            document.getElementById('estado-error').innerHTML = 'El campo estado es obligatorio';
        }

        if (hasErrors) {
            event.preventDefault();
            document.getElementById('general-errors').innerHTML = 'Todos los campos son requeridos';
        }
    });

    document.querySelectorAll('[data-modal-hide="static-modal"]').forEach((button) => {
        button.addEventListener('click', function() {
            updateTitle('Añadir Ciclo');
            document.getElementById('add-ciclo-form').action = '{{ route('ciclos.store') }}';
            document.getElementById('add-ciclo-form').method = 'POST';
            method = document.querySelector('[name="_method"]')
            if(method) document.getElementById('add-ciclo-form').removeChild(method);
            document.getElementById('add-ciclo-form').reset();
            document.getElementById('general-errors').innerHTML = '';
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const anio = this.getAttribute('data-anio');
            const tipoCiclo = this.getAttribute('data-tipo_ciclo');
            const estado = this.getAttribute('data-estado');

            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));

            updateTitle('Editar ciclo')

            document.getElementById('add-ciclo-form').action = `/mantenimientos/ciclos/${id}`;
            document.getElementById('add-ciclo-form').method = 'POST';
            document.getElementById('add-ciclo-form').innerHTML +=
                '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('anio').value = anio;
            document.getElementById('id_tipo_ciclo').value = tipoCiclo;
            document.getElementById('activo').value = estado;

            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });

    function updateTitle(title) {
        document.getElementById('modal-title').textContent = title;
    }
</script>
