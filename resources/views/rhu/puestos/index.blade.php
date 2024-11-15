@php
    $headers = [
        ['text' => 'Puesto', 'align' => 'left'],
        ['text' => 'Entidad', 'align' => 'left'], // Nueva columna
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acciones', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.simple titulo="Gestión de Puestos" />
    </x-slot>
    <div>
        <div class="p-6">
            <x-forms.primary-button data-modal-target="static-modal" data-modal-toggle="static-modal" class="block"
                type="button" id="add-button">
                Añadir
            </x-forms.primary-button>
        </div>
        <x-table.base :headers="$headers">
            @foreach ($puestos as $puesto)
                <x-table.tr>
                    <x-table.td>
                        {{ $puesto->nombre }}
                    </x-table.td>
                    <x-table.td>
                        {{ $puesto->entidad->nombre }}
                    </x-table.td>
                    <x-table.td>
                        <x-status.is-active :active="$puesto->activo" />
                    </x-table.td>
                    <x-table.td>
                        <a href="#"
                            class="edit-button font-medium text-green-600 hover:underline dark:text-green-400"
                            data-id="{{ $puesto->id }}" data-nombre="{{ $puesto->nombre }}"
                            data-entidad="{{ $puesto->id_entidad }}" data-activo="{{ $puesto->activo }}">
                            <x-heroicon-o-pencil class="h-5 w-5" />
                        </a>
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.base>
        <nav class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row"
            aria-label="Table navigation">
            {{ $puestos->links() }}
        </nav>
    </div>

    <x-form-modal id="static-modal">
        <x-slot name="header">
            <h3 id="head-text" class="text-2xl font-bold text-escarlata-ues">Añadir Puesto</h3>
        </x-slot>
        <x-slot name="body">
            <form id="add-puesto-form" method="POST" action="{{ route('puestos.store') }}">
                @csrf
                <x-forms.row :columns="1">
                    <x-forms.field label="Nombre" name="nombre" type="text" :value="old('nombre')" :error="$errors->get('nombre')" />
                    <x-forms.select label="Entidad" id="id_entidad" name="id_entidad" :options="$entidades->pluck('nombre', 'id')->toArray()"
                        :value="old('id_entidad')" :error="$errors->get('id_entidad')" />
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
            <button type="submit" form="add-puesto-form"
                class="ms-6 rounded-lg bg-red-700 px-8 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4">
                Guardar
            </button>
        </x-slot>
    </x-form-modal>
</x-app-layout>
<script>
  document.querySelectorAll('.edit-button').forEach((button) => {
     button.addEventListener('click', function(event) {
         event.preventDefault();

         // Obtener los datos del puesto desde los atributos del botón
         const id = this.getAttribute('data-id');
         const nombre = this.getAttribute('data-nombre');
         const id_entidad = this.getAttribute('data-entidad');
         const activo = this.getAttribute('data-activo');

         // Verificar los valores obtenidos
         console.log(id, nombre, id_entidad, activo);

         // Configurar el formulario para la edición
         const form = document.getElementById('add-puesto-form');
         form.action = `/rhu/puestos/${id}`;
         form.method = 'POST';
         if (!form.querySelector('input[name="_method"]')) {
             form.innerHTML += '<input type="hidden" name="_method" value="PUT">';
         }

         // Asignar valores al formulario
         document.getElementById('nombre').value = nombre;
         document.getElementById('id_entidad').value = id_entidad;
         document.getElementById('activo').value = activo;

         // Configurar el título del modal
         document.getElementById('head-text').textContent = 'Editar Puesto';

         // Abrir el modal
         document.querySelector('[data-modal-target="static-modal"]').click();
     });
 });

</script>
