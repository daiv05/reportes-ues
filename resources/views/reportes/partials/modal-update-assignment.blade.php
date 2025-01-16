<x-modal name="actualizar-seguimiento-modal" :show="false" maxWidth="5xl">
    <form id="updateForm" method="POST" action="{{ route('reportes.actualizarEstado', ['id' => $reporte->id]) }}"
          enctype="multipart/form-data">
        @csrf
        <div class="p-6 flex flex-col items-center w-full">
            <h2 class="text-lg font-medium text-escarlata-ues dark:text-gray-100">
                Actualizar seguimiento de reporte
            </h2>
            <div class="mt-4 w-full">
                <label for="id_estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Actualizar
                    a</label>
                <select id="id_estado" name="id_estado"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Seleccionar estado</option>
                    @foreach ($estadosPermitidos as $estado)
                        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                    @endforeach
                </select>
                <span id="id_estado_error" class="text-red-500 text-sm"></span>
                @include('components.forms.input-error', ['messages' => $errors->get('id_estado')])
            </div>
            <div class="mt-4 w-full">
                <label for="comentarios"
                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">Comentarios</label>
                <textarea id="comentarios" name="comentario" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                <span id="comentarios_error" class="text-red-500 text-sm"></span>
                @include('components.forms.input-error', ['messages' => $errors->get('comentario')])
            </div>
            <div class="mt-4 w-full">
                <label for="evidencia"
                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">Evidencia</label>
                <input type="file" id="evidencia" name="evidencia"
                       class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 rounded-md cursor-pointer focus:outline-none focus:border-indigo-500 focus:ring-indigo-500">
                <span id="evidencia_error" class="text-red-500 text-sm"></span>
                @include('components.forms.input-error', ['messages' => $errors->get('evidencia')])
            </div>
            @if(!($reporte->relacion_usuario['supervisor'] && $reporte->estado_ultimo_historial?->id === 4))
                <div class="mt-4 w-full">
                    <label for="recursos_utilizados" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recursos
                        utilizados</label>
                    <select id="recursos_utilizados"
                            data-hs-select='{
          "hasSearch": true,
          "searchPlaceholder": "Búsqueda de recursos",
          "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] py-2 px-3",
          "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0",
          "placeholder": "Seleccione un recurso...",
          "toggleTag": "<button type=\"button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-gray-800 \" data-title></span></button>",
          "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500",
          "dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300",
          "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100",
          "optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-gray-800 \" data-title></div></div></div>",
          "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
        }'
                            class="block">
                        <option value="">Seleccione un recurso</option>
                        @foreach ($recursos as $recurso)
                            <option value="{{ $recurso->id }}" data-nombre="{{ $recurso->nombre }}">
                                {{ $recurso->nombre }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-green-500">Seleccione un elemento de la lista para añadirlo</p>

                    <input type="hidden" id="recursos_input" name="recursos">
                    <div class="relative overflow-x-auto">
                        <table id="recursos_table"
                               class="mt-8 min-w-[650px] w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 hidden">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-2 py-1 w-[30%]">Nombre</th>
                                <th scope="col" class="px-2 py-1 w-[10%]">Cantidad</th>
                                <th scope="col" class="px-2 py-1 w-[30%]">Unidad de medida</th>
                                <th scope="col" class="px-2 py-1 w-[25%]">Fondo</th>
                                <th scope="col" class="px-2 py-1 w-[5%]">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- Filas dinámicas se añadirán aquí -->
                            </tbody>
                        </table>
                    </div>

                    <script>
                        const recursosSeleccionados = [];
                        const unidadesMedida = @json($unidadesMedida);
                        const fondos = @json($fondos);

                        document.getElementById('recursos_utilizados').addEventListener('change', function () {
                            const selectedOption = this.options[this.selectedIndex];
                            const recursoId = selectedOption.value;
                            const recursoNombre = selectedOption.getAttribute('data-nombre');

                            if (recursoId && !recursosSeleccionados.some(recurso => recurso.id_recurso === recursoId)) {
                                const recurso = {
                                    id_recurso: recursoId,
                                    nombre: recursoNombre,
                                    id_unidad_medida: unidadesMedida[0].id,
                                    cantidad: 1,
                                    id_fondo: fondos[0].id
                                };

                                recursosSeleccionados.push(recurso);
                                actualizarTablaRecursos();
                            }
                        });

                        function actualizarTablaRecursos() {
                            const tbody = document.getElementById('recursos_table').querySelector('tbody');
                            tbody.innerHTML = '';

                            recursosSeleccionados.forEach((recurso, index) => {
                                const row = document.createElement('tr');
                                row.classList.add('bg-white', 'border-b', 'dark:bg-gray-800', 'dark:border-gray-700');

                                row.innerHTML = `
                <td class="px-2 py-4">${recurso.nombre}</td>
                <td class="px-2 py-4">
                    <input type="number" value="${recurso.cantidad}" min="1" max="100" onchange="actualizarCantidad(${index}, this.value)" class="w-full h-10 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </td>
                <td class="px-2 py-4">
                    <select onchange="actualizarUnidad(${index}, this.value)" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        ${unidadesMedida.map(unidad => `<option value="${unidad.id}" ${unidad.id == recurso.id_unidad_medida ? 'selected' : ''}>${unidad.nombre}</option>`).join('')}
                    </select>
                </td>
                <td class="px-2 py-4">
                    <select onchange="actualizarFondo(${index}, this.value)" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        ${fondos.map(fondo => `<option value="${fondo.id}" ${fondo.id == recurso.id_fondo ? 'selected' : ''}>${fondo.nombre.replace('FONDO', '').trim()}</option>`).join('')}
                    </select>
                </td>
                <td class="px-2 py-4"><button type="button" onclick="eliminarRecurso(${index})" class="w-full flex justify-center text-red-500"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg></button></td>
            `;

                                tbody.appendChild(row);
                            });

                            document.getElementById('recursos_input').value = JSON.stringify(recursosSeleccionados);
                            document.getElementById('recursos_table').classList.toggle('hidden', recursosSeleccionados.length === 0);
                        }

                        function actualizarCantidad(index, cantidad) {
                            recursosSeleccionados[index].cantidad = cantidad;
                            document.getElementById('recursos_input').value = JSON.stringify(recursosSeleccionados);
                        }

                        function actualizarFondo(index, fondo) {
                            recursosSeleccionados[index].id_fondo = fondo;
                            document.getElementById('recursos_input').value = JSON.stringify(recursosSeleccionados);
                        }

                        function actualizarUnidad(index, unidad) {
                            recursosSeleccionados[index].id_unidad_medida = unidad;
                            document.getElementById('recursos_input').value = JSON.stringify(recursosSeleccionados);
                        }

                        function eliminarRecurso(index) {
                            recursosSeleccionados.splice(index, 1);
                            actualizarTablaRecursos();
                        }
                    </script>
                    <span id="recursos_utilizados_error" class="text-red-500 text-sm"></span>
                    @include('components.forms.input-error', ['messages' => $errors->get('recursos_utilizados')])

                </div>
            @endif
        </div>
        <div class="flex justify-center px-6 py-4 bg-gray-100 dark:bg-gray-800 text-right w-full">
            <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded"
                    x-on:click="$dispatch('close-modal', 'actualizar-seguimiento-modal')">
                Cerrar
            </button>
            <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded ml-2">
                Enviar
            </button>
        </div>
    </form>
</x-modal>

<script>
    document.getElementById('updateForm').addEventListener('submit', function (event) {
        let valid = true;

        document.getElementById('id_estado_error').textContent = '';
        document.getElementById('comentarios_error').textContent = '';

        const idEstado = document.getElementById('id_estado');
        if (idEstado.value === '') {
            document.getElementById('id_estado_error').textContent = 'Seleccione un estado.';
            valid = false;
        }

        const comentarios = document.getElementById('comentarios');
        if (comentarios.value.trim() === '') {
            document.getElementById('comentarios_error').textContent = 'Ingrese un comentario.';
            valid = false;
        }

        if (!valid) {
            event.preventDefault();
        }
    });
</script>
