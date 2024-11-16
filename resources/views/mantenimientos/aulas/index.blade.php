@php
    $headers = [
        ['text' => 'Nombre', 'align' => 'left'],
        ['text' => 'Nombre', 'align' => 'Facultad'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acción', 'align' => 'left'],
    ];
@endphp
<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de aulas" />
    </x-slot>
    <div>
        <div class="p-6">
            <x-forms.primary-button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block"
                type="button">
                Añadir
            </x-forms.primary-button>
        </div>
        <div
            class="mx-auto flex min-w-full flex-col items-center justify-center overflow-x-auto shadow-md sm:rounded-lg">
            <x-table.base :headers="$headers">
                @foreach ($aulas as $aula)
                    <x-table.tr>
                        <x-table.td>
                            {{ $aula->nombre }}
                        </x-table.td>
                        <x-table.td>
                            {{ $aula->facultades->nombre }}
                        </x-table.td>
                        <x-table.td>
                            <x-status.is-active :active="$aula->activo" />
                        </x-table.td>
                        <x-table.td>
                            <a href="#"
                                class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                                data-id="{{ $aula->id }}" data-nombre="{{ $aula->nombre }}"
                                data-facultad="{{ $aula->facultades->id }}" data-activo="{{ $aula->activo }}">
                                <x-heroicon-o-pencil class="h-5 w-5" />
                            </a>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.base>
            </table>
            <nav class="flex-column flex flex-wrap items-center justify-between pt-4 md:flex-row"
                aria-label="Table navigation">
                {{ $aulas->links() }}
            </nav>
        </div>
    </div>

    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 class="text-2xl font-bold text-escarlata-ues">Añadir Aula</h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-aula-form" method="POST" action="{{ route('aulas.store') }}">
                @csrf
                <x-forms.row :columns="1">
                    <x-forms.select label="Facultad" id="id_facultad" name="id_facultad" :options="$facultades->pluck('nombre', 'id')->toArray()"
                        :value="old('id_facultad')" :error="$errors->get('id_facultad')" />
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
            <button type="submit" form="add-aula-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>
<script>
    document.getElementById('add-aula-form').addEventListener('submit', function(event) {
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
            document.getElementById('add-aula-form').reset();
            document.getElementById('general-errors').innerHTML = '';
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const facultad = this.getAttribute('data-facultad');
            const activo = this.getAttribute('data-activo');

            document.getElementById('add-aula-form').action = `/mantenimientos/aulas/${id}`;
            document.getElementById('add-aula-form').method = 'POST';
            document.getElementById('add-aula-form').innerHTML +=
                '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('nombre').value = nombre;
            document.getElementById('id_facultad').value = facultad;
            document.getElementById('activo').value = activo;

            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });
</script>
