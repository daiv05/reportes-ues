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

        <div class="p-6">
            <x-forms.primary-button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block"
                type="button">
                Añadir
            </x-forms.primary-button>
        </div>
    </x-slot>
    <x-container>
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
        <nav class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row"
            aria-label="Table navigation">
            {{ $asignaturas->links() }}
        </nav>
    </x-container>

    <!-- Modal agregar-->
    <x-form-modal id="static-modal" class="hidden">
        <x-slot name="header">
            <h3 id="modal-title" class="text-2xl font-bold text-escarlata-ues">Añadir asignatura</h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-asignatura-form" method="POST" action="{{ route('asignatura.store') }}">
                @csrf
                <div id="general-errors" class="mb-4 text-sm text-red-500"></div>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.select label="Escuela" id="id_escuela" name="id_escuela" :options="$escuelas->pluck('nombre', 'id')->toArray()"
                            :value="old('id_escuela')" :error="$errors->get('id_escuela')" required />
                        <div id="escuela-error" class="text-sm text-red-500"></div>
                    </div>
                    <div>
                        <x-forms.field id="nombre" label="Nombre" name="nombre" :value="old('nombre')" :error="$errors->get('nombre')"
                            required />
                        <div id="nombre-error" class="text-sm text-red-500"></div>
                    </div>
                    <div>
                        <x-forms.select label="Estado" id="activo" name="activo" :options="['1' => 'ACTIVO', '0' => 'INACTIVO']" :value="old('activo', '1')"
                            :error="$errors->get('activo')" required />
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
            <button type="submit" form="add-asignatura-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>

<script>
    function centerModal(modal) {
        const modalContent = modal.querySelector('.relative');
        if (!modalContent) return;

        const modalRect = modalContent.getBoundingClientRect();
        const windowHeight = window.innerHeight;
        const windowWidth = window.innerWidth;


        const offsetTop = (windowHeight - modalRect.height) / 2;
        const offsetLeft = (windowWidth - modalRect.width) / 2;


        modalContent.style.position = 'absolute';
        modalContent.style.top = `${offsetTop}px`;
        modalContent.style.left = `${offsetLeft}px`;
        modalContent.style.zIndex = '1000';

    }
    @if ($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('static-modal');
            if (modal) {
                updateModalTitle('Editar Asignatura');

                modal.classList.remove('hidden');
                modal.classList.add('bg-black', 'bg-opacity-50');


                setTimeout(function() {
                    centerModal(modal);
                }, 0);
            }
        });
    @endif



    document.getElementById('add-asignatura-form').addEventListener('submit', function(event) {

        const nombre = document.getElementById('nombre').value.trim();
        const escuela = document.getElementById('id_escuela').value.trim();
        const estado = document.getElementById('activo').value.trim();

        let hasErrors = false;

        document.getElementById('general-errors').innerHTML = '';
        document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));

        if (!nombre) {
            hasErrors = true;
            document.getElementById('nombre-error').innerHTML = 'El campo Nombre es obligatorio';
        }

        if (!escuela) {
            hasErrors = true;
            document.getElementById('escuela-error').innerHTML = 'El campo Escuela es obligatorio';
        }

        if (!estado) {
            hasErrors = true;
            document.getElementById('estado-error').innerHTML = 'El campo Estado es obligatorio';
        }

        if (hasErrors) {
            event.preventDefault();
            document.getElementById('general-errors').innerHTML = 'Todos los campos son requeridos';
        }
    });

    document.querySelectorAll('[data-modal-hide="static-modal"]').forEach((button) => {
        button.addEventListener('click', function() {
            updateModalTitle('Añadir Asignatura');

            resetForm();

            document.getElementById('add-asignatura-form').method = 'POST';
            document.getElementById('add-asignatura-form').action = "{{ route('asignatura.store') }}";

            document.querySelectorAll('input[name="_method"]').forEach((input) => input.remove());
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function() {

            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const escuela = this.getAttribute('data-escuela');
            const activo = this.getAttribute('data-activo');

            updateModalTitle('Editar Asignatura');

            document.getElementById('add-asignatura-form').action = `/mantenimientos/asignatura/${id}`;
            document.getElementById('add-asignatura-form').method = 'POST';

            if (!document.querySelector('input[name="_method"]')) {
                document.getElementById('add-asignatura-form').innerHTML +=
                    '<input type="hidden" name="_method" value="PUT">';
            }

            document.getElementById('nombre').value = nombre;
            document.getElementById('id_escuela').value = escuela;
            document.getElementById('activo').value = activo;

            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });


    function updateModalTitle(title) {
        document.getElementById('modal-title').textContent = title;
    }


    function resetForm() {
        document.getElementById('add-asignatura-form').reset();
        document.getElementById('general-errors').innerHTML = '';


        document.querySelector('form').addEventListener('submit', function(event) {

            document.querySelectorAll('.text-red-500').forEach(errorElement => {
                errorElement.textContent = '';
            });
        });



        document.querySelectorAll('select').forEach((select) => {
            select.selectedIndex = 0;
        });

        document.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('focus', function() {
                const errorElement = document.getElementById(input.name + '-error');
                if (errorElement) {
                    errorElement.innerHTML = '';
                }
            });

            input.addEventListener('input', function() {
                const errorElement = document.getElementById(input.name + '-error');
                if (errorElement) {
                    errorElement.innerHTML = '';
                }
            });
        });

        document.querySelectorAll('input').forEach((input) => {
            if (input.type === 'text' || input.type === 'password' || input.type === 'email' || input.type ===
                'tel' || input.type === 'search') {
                input.value = '';
            } else if (input.type === 'checkbox' || input.type === 'radio') {
                input.checked = false;
            } else if (input.type === 'number') {
                input.value = '';
            } else if (input.type === 'date') {
                input.value = '';
            }
        });

    }
</script>
