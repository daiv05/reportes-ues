@php
    $headers = [
        ['text' => 'Año', 'align' => 'left'],
        ['text' => 'Tipo de Ciclo', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acción', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de Ciclos" />
    </x-slot>

    <div>
        <div class="p-6">
            <x-forms.primary-button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block"
                type="button" id="add-button">
                Añadir Ciclo
            </x-forms.primary-button>
        </div>
        <div class="mx-auto mb-8 flex flex-col items-center justify-center overflow-x-auto sm:rounded-lg">
            <x-table.base :headers="$headers">
                @foreach ($ciclos as $ciclo)
                    <x-table.tr>
                        <x-table.td>
                            {{ $ciclo->anio }}
                        </x-table.td>
                        <x-table.td>
                            {{ $ciclo->tipoCiclo->nombre }}
                        </x-table.td>
                        <x-table.td>
                            <x-status.is-active :active="$ciclo->activo" />
                        </x-table.td>
                        <x-table.td>
                            <a href="#"
                                class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                data-id="{{ $ciclo->id }}" data-anio="{{ $ciclo->anio }}"
                                data-tipo_ciclo="{{ $ciclo->id_tipo_ciclo }}" data-activo="{{ $ciclo->activo }}">
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
    </div>

    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 class="text-2xl font-bold text-escarlata-ues">Añadir Ciclo</h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-ciclo-form" method="POST" action="{{ route('ciclos.store') }}">
                @csrf
                <x-forms.row :columns="1">
                    <x-forms.field label="Año" name="anio" :value="old('anio')" :error="$errors->get('anio')" />
                    <x-forms.select label="Tipo de Ciclo" id="id_tipo_ciclo" name="id_tipo_ciclo" :options="$tiposCiclos->pluck('nombre', 'id')->toArray()"
                        :value="old('id_tipo_ciclo')" :error="$errors->get('id_tipo_ciclo')" />
                    <x-forms.select label="Estado" id="activo" name="activo" :options="['1' => 'ACTIVO', '0' => 'INACTIVO']" :value="old('activo', '1')"
                        :error="$errors->get('activo')" />
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
        let hasErrors = false;
        let errorMessage = '';

        const anio = document.getElementById('anio').value.trim();
        if (anio === '') {
            hasErrors = true;
            errorMessage += 'El campo Año es obligatorio<br>';
        }

        if (hasErrors) {
            event.preventDefault();
            document.getElementById('general-errors').innerHTML = errorMessage;
        }
    });

    document.querySelectorAll('[data-modal-hide="static-modal"]').forEach((button) => {
        button.addEventListener('click', function() {
            document.getElementById('add-ciclo-form').reset();
            document.getElementById('general-errors').innerHTML = '';
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));

                    // Limpiar los atributos data-* de los botones o elementos relacionado
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const anio = this.getAttribute('data-anio');
            const tipoCiclo = this.getAttribute('data-tipo_ciclo');
            const activo = this.getAttribute('data-activo');

            document.getElementById('add-ciclo-form').action = `/mantenimientos/ciclos/${id}`;
            document.getElementById('add-ciclo-form').method = 'POST';
            document.getElementById('add-ciclo-form').innerHTML +=
                '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('anio').value = anio;
            document.getElementById('id_tipo_ciclo').value = tipoCiclo;
            document.getElementById('activo').value = activo;

            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });
</script>
