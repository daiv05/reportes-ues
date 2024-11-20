@php
    $headers = [
        ['text' => 'Nombre', 'align' => 'left'],
        ['text' => 'Facultad', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acciones', 'align' => 'center'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de Escuelas" />
        <div class="p-6">
            <x-forms.primary-button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block"
                type="button">
                Añadir
            </x-forms.primary-button>
        </div>
    </x-slot>

    <x-container>
        <x-table.base :headers="$headers">
            @foreach ($escuelas as $escuela)
                <x-table.tr>
                    <x-table.td>{{ $escuela->nombre }}</x-table.td>
                    <x-table.td>{{ $escuela->facultades->nombre }}</x-table.td>
                    <x-table.td justify="center"><x-status.is-active :active="$escuela->activo" /></x-table.td>
                    <x-table.td justify="center">
                        <a href="#"
                            class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                            data-id="{{ $escuela->id }}" data-nombre="{{ $escuela->nombre }}"
                            data-facultad="{{ $escuela->facultades->id }}" data-estado="{{ $escuela->activo }}">
                            <x-heroicon-o-pencil class="h-5 w-5" />
                        </a>
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.base>
        <nav class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row"
            aria-label="Table navigation">
            {{ $escuelas->links() }}
        </nav>
    </x-container>

    <!-- Modal agregar-->
    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 id="modal-title" class="text-2xl font-bold text-escarlata-ues">Añadir escuela</h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-escuela-form" method="POST" action="{{ route('escuela.store') }}">
                @csrf
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.select label="Facultad" id="id_facultad" name="id_facultad" :options="$facultades->pluck('nombre', 'id')->toArray()"
                            :value="old('id_facultad')" :error="$errors->get('id_facultad')" required />
                        <div id="facultad-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.field label="Nombre" name="nombre" type="text" :value="old('name')" :error="$errors->get('name')" required />
                        <div id="nombre-error" class="text-sm text-red-500"></div>
                    </div>
                </x-forms.row>
                <x-forms.row :columns="1">
                    <div>
                        <x-forms.select label="Estado" id="activo" name="activo" :options="[1 => 'ACTIVO', 0 => 'INACTIVO']" :selected="1"
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
            <button type="submit" form="add-escuela-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>
<script>
    document.getElementById('add-escuela-form').addEventListener('submit', function(event) {
        const facultad = document.getElementById('id_facultad').value.trim();
        const nombre = document.getElementById('nombre').value.trim();
        const estado = document.getElementById('activo').value.trim();

        let hasErrors = false;

        if (!facultad) {
            hasErrors = true;
            document.getElementById('facultad-error').innerHTML = 'El campo facultad es obligatorio';
        }

        if (!nombre) {
            hasErrors = true;
            document.getElementById('nombre-error').innerHTML = 'El campo nombre es obligatorio';
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
            updateTitle('Añadir escuela');
            document.getElementById('add-escuela-form').action = '{{ route('escuela.store') }}';
            document.getElementById('add-escuela-form').method = 'POST';
            method = document.querySelector('[name="_method"]')
            if(method) document.getElementById('add-escuela-form').removeChild(method);
            document.getElementById('add-escuela-form').reset();
            document.getElementById('general-errors').innerHTML = '';
            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));
        });
    });

    document.querySelectorAll('.edit-button').forEach((button) => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const nombre = this.getAttribute('data-nombre');
            const facultad = this.getAttribute('data-facultad');
            const estado = this.getAttribute('data-estado');

            document.querySelectorAll('.text-red-500').forEach((error) => (error.innerHTML = ''));

            updateTitle('Editar escuela');

            document.getElementById('add-escuela-form').action = `/mantenimientos/escuela/${id}`;
            document.getElementById('add-escuela-form').method = 'POST';
            document.getElementById('add-escuela-form').innerHTML +=
                '<input type="hidden" name="_method" value="PUT">';

            document.getElementById('nombre').value = nombre;
            document.getElementById('id_facultad').value = facultad;
            document.getElementById('activo').value = estado;

            document.querySelector('[data-modal-target="static-modal"]').click();
        });
    });
    function updateTitle(title) {
        document.getElementById('modal-title').textContent = title;
    }
</script>
