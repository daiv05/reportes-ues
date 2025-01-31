@php
    $headersBienes = [
        ['text' => 'Código', 'align' => 'left'],
        ['text' => 'Nombre', 'align' => 'left'],
        ['text' => 'Acciones', 'align' => 'center'],
    ];
@endphp

<div>
    {{-- Busqueda por Tipo de bien y nombre --}}
    <div class="flex flex-row justify-center md:justify-start space-x-2">
        <label class="p-2.5">Filtrar:</label>
        <select id="tipoBien"
                class="max-w-80 border border-gray-300 text-gray-900 focus:border-red-500 focus:outline-none focus:ring-red-500 text-sm rounded-lg block w-full p-2.5">
            <option value="">Todas</option>
            @foreach ($tiposBienes as $tipo)
                <option value="{{ $tipo->id }}">
                    {{ $tipo->nombre }}
                </option>
            @endforeach
        </select>
        <input type="text" id="nombre-busqueda-bienes" name="nombre"
               class="block w-full sm:w-80 rounded-lg border border-gray-300 p-2 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-red-500 dark:focus:ring-red-500"
               placeholder="Nombre/Código"/>
    </div>

    <div class="my-4">
        <div class="overflow-x-auto">
            {{-- TABLA --}}
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const tipoBienSelect = document.getElementById('tipoBien');
                    const nombreBusquedaInput = document.getElementById('nombre-busqueda-bienes');
                    const idBienes = [];
                    const selectedBienes = [];

                    function fetchData() {
                        const tipoBien = tipoBienSelect.value;
                        const search = nombreBusquedaInput.value;
                        const url = `/mantenimientos/bienes/filtro?id_tipo_bien=${tipoBien}&search=${search}`;
                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                const tableBody = document.getElementById('bienes-table-body');
                                tableBody.innerHTML = '';

                                data.forEach(item => {
                                    const row = document.createElement('tr');
                                    row.classList.add('bg-white', 'border-b');
                                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${item.codigo}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.nombre}</td>
                        <td class="px-6 py-4 text-center">
                            <button type="button" class="text-green-500 hover:text-green-700 cursor-pointer" data-id="${item.id}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </td>
                    `;
                                    tableBody.appendChild(row);
                                });

                                document.querySelectorAll('button[data-id]').forEach(button => {
                                    button.addEventListener('click', function () {
                                        const id = parseInt(this.getAttribute('data-id'), 10);
                                        const item = data.find(bien => bien.id === id);

                                        if (!idBienes.includes(id)) {
                                            idBienes.push(id);
                                            selectedBienes.push(item);
                                            updateSelectedTable();
                                            updateHiddenInput();
                                        }
                                    });
                                });
                            })
                            .catch(error => {
                                console.error('Error');
                            });
                    }

                    function updateSelectedTable() {
                        const selectedTableBody = document.getElementById('selected-bienes-table-body');
                        selectedTableBody.innerHTML = '';

                        selectedBienes.forEach(item => {
                            const selectedRow = document.createElement('tr');
                            selectedRow.classList.add('bg-white', 'border-b');
                            selectedRow.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${item.codigo}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.nombre}</td>
                <td class="px-6 py-4 text-center">
                    <button type="button" class="text-red-500 hover:text-red-700 cursor-pointer" data-id="${item.id}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M6.293 4.293a1 1 0 011.414 0L10 6.586l2.293-2.293a1 1 0 111.414 1.414L11.414 8l2.293 2.293a1 1 0 11-1.414 1.414L10 9.414l-2.293 2.293a1 1 0 11-1.414-1.414L8.586 8 6.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </td>
            `;
                            selectedTableBody.appendChild(selectedRow);

                            selectedRow.querySelector('button[data-id]').addEventListener('click', function () {
                                const removeId = parseInt(this.getAttribute('data-id'), 10);
                                const index = idBienes.indexOf(removeId);
                                if (index > -1) {
                                    idBienes.splice(index, 1);
                                    selectedBienes.splice(index, 1);
                                    updateSelectedTable();
                                    updateHiddenInput();
                                }
                            });
                        });
                    }

                    function updateHiddenInput() {
                        const hiddenInput = document.getElementById('id_bienes');
                        hiddenInput.value = JSON.stringify(idBienes);
                    }

                    tipoBienSelect.addEventListener('change', fetchData);
                    nombreBusquedaInput.addEventListener('input', fetchData);

                    fetchData();
                });
            </script>

            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Código</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Nombre</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-500">Acciones</th>
                </tr>
                </thead>
                <tbody id="bienes-table-body">
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8">
        <span class="text-gray-600">Registros seleccionados</span>
        <div class="overflow-x-auto mt-4">
            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Código</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Nombre</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-500">Acciones</th>
                </tr>
                </thead>
                <tbody id="selected-bienes-table-body">
                <!-- Selected rows will be populated here by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <input hidden id="id_bienes" name="id_bienes" value="[]">
</div>
