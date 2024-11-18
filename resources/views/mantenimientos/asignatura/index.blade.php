@php
    $headers = [
        ['text' => 'Nombre', 'align' => 'left'],
        ['text' => 'Nombre', 'align' => 'Escuela'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acción', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de Asignaturas" />
    </x-slot>

    <div>
        <div class="p-6">
            <x-forms.primary-button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block"
                type="button">
                Añadir
            </x-forms.primary-button>
        </div>
        <!-- tabla de datos -->
        <div class="mx-auto flex flex-col items-center justify-center overflow-x-auto shadow-md sm:rounded-lg">
            <x-table.base :headers="$headers">
                @foreach ($asignaturas as $asignatura)
                    <x-table.tr>
                        <x-table.td>
                            {{ $asignatura->nombre }}
                        </x-table.td>
                        <x-table.td>
                            {{ $asignatura->escuela->nombre }}
                        </x-table.td>
                        <x-table.td>
                            <x-status.is-active :active="$asignatura->activo" />
                        </x-table.td>
                        <x-table.td>
                            <a href="#"
                                class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                data-id="{{ $asignatura->id }}" data-nombre="{{ $asignatura->nombre }}"
                                data-escuela="{{ $asignatura->escuela->id }}" data-activo="{{ $asignatura->activo }}">
                                <x-heroicon-o-pencil class="h-5 w-5" />
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.base>
            <nav class="flex-column flex flex-wrap items-center justify-between pt-4 md:flex-row"
                aria-label="Table navigation">
                {{ $asignaturas->links() }}
            </nav>
        </div>
    </div>

    <!-- Modal agregar-->
    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 class="text-2xl font-bold text-escarlata-ues">Añadir asignatura</h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-asignatura-form" method="POST" action="{{ route('asignatura.store') }}">
                @csrf
                <x-forms.row :columns="1">
                    <x-forms.select label="Escuela" id="id_escuela" name="id_escuela" :options="$escuelas->pluck('nombre', 'id')->toArray()"
                        :value="old('id_escuela')" :error="$errors->get('id_escuela')" />
                    <x-forms.field label="Nombre" name="nombre" :value="old('nombre')" :error="$errors->get('nombre')" />
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
            <button type="submit" form="add-asignatura-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>
<script>
    document.getElementById('add-asignatura-form').addEventListener('submit', function(event) {
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
        button.addEventListener('click', function() {
            document.getElementById('add-asignatura-form').reset();
            document.getElementById('general-errors').innerHTML = '';
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const escuela = this.getAttribute('data-escuela');
            const activo = this.getAttribute('data-activo');

            document.getElementById('add-asignatura-form').action = `/mantenimientos/asignatura/${id}`;
            document.getElementById('add-asignatura-form').method = 'POST';
            document.getElementById('add-asignatura-form').innerHTML +=
                '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('nombre').value = nombre;
            document.getElementById('id_escuela').value = escuela;
            document.getElementById('activo').value = activo;

            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });
</script>
<script>
    const toastData2 = @json(session('message'));
    if (toastData2) {
        fireToastDV(toastData2)
    }
</script>
