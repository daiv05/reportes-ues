@php
    $headersBienes = [
        ['text' => 'Código', 'align' => 'left'],
        ['text' => 'Nombre', 'align' => 'left'],
        ['text' => 'Acciones', 'align' => 'center'],
    ];
@endphp

<div>
    {{-- Busqueda por Tipo de bien y nombre --}}
    <div class="flex flex-row justify-center space-x-2 md:justify-start">
        <label class="p-2.5">Filtrar:</label>
        <select
            id="tipoBien"
            class="block w-full max-w-80 rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-red-500 focus:outline-none focus:ring-red-500"
        >
            <option value="">Todas</option>
            @foreach ($tiposBienes as $tipo)
                <option value="{{ $tipo->id }}">
                    {{ $tipo->nombre }}
                </option>
            @endforeach
        </select>
        <input
            type="text"
            id="nombre-busqueda-bienes"
            name="nombre"
            maxlength="50"
            class="block w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-red-500 dark:focus:ring-red-500 sm:w-80"
            placeholder="Nombre/Código"
        />
    </div>

    <div class="my-4">
        <div class="overflow-x-auto">
            {{-- TABLA --}}
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    let timeout = null;
                    const tipoBienSelect = document.getElementById('tipoBien');
                    const nombreBusquedaInput = document.getElementById('nombre-busqueda-bienes');
                    const idBienes = [];
                    const selectedBienes = [];

                    initializeTooltips();

                    async function fetchData() {
                        const tipoBien = tipoBienSelect.value;
                        const search = nombreBusquedaInput.value;
                        const url = `/mantenimientos/bienes/filtro?id_tipo_bien=${tipoBien}&search=${search}`;
                        try {
                            const response = await fetch(url);
                            if (!response.ok) {
                                throw new Error('Error al obtener los datos');
                            }
                            const responseJson = await response.json();
                            const tableBody = document.getElementById('bienes-table-body');
                                tableBody.innerHTML = '';
                                responseJson.forEach((item) => {
                                    const row = document.createElement('tr');
                                    row.classList.add('bg-white', 'border-b');
                                    row.innerHTML = `
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${item.codigo}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.nombre}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.descripcion}</td>
                                    <td class="px-6 py-4 text-center">
                                        <button type="button" class="text-green-500 hover:text-green-700 cursor-pointer" data-id="${item.id}" data-tooltip-target="tooltip-add-${item.id}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>

                                        <div
                                            id="tooltip-add-${item.id}"
                                            role="tooltip"
                                            class="shadow-xs tooltip z-40 inline-block rounded-lg bg-green-800 px-3 py-2 text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                                        >
                                            Agregar bien
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </td>
                                `;
                                    tableBody.appendChild(row);
                                });

                                document.querySelectorAll('button[data-id]').forEach((button) => {
                                    button.addEventListener('click', function () {
                                        const id = parseInt(this.getAttribute('data-id'), 10);
                                        const item = responseJson.find((bien) => bien.id === id);

                                        if (!idBienes.includes(id)) {
                                            idBienes.push(id);
                                            selectedBienes.push(item);
                                            updateSelectedTable();
                                            updateHiddenInput();
                                        }
                                    });
                                });
                                initializeTooltips();
                        } catch (error) {
                            console.log(error);
                            if (error.id_tipo_bien) {
                                noty(error.id_tipo_bien[0], 'warning');
                            }
                            if (error.search) {
                                console.log(error.search[0]);
                                noty(error.search[0], 'warning');
                            }
                        }
                    }

                    function updateSelectedTable() {
                        const selectedTableBody = document.getElementById('selected-bienes-table-body');
                        selectedTableBody.innerHTML = '';

                        selectedBienes.forEach((item) => {
                            const selectedRow = document.createElement('tr');
                            selectedRow.classList.add('bg-white', 'border-b');
                            selectedRow.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${item.codigo}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.nombre}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.descripcion}</td>
                <td class="px-6 py-4 text-center">
                    <button type="button" class="text-red-500 hover:text-red-700 cursor-pointer" data-id="${item.id}" data-tooltip-target="tooltip-remove-${item.id}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M6.293 4.293a1 1 0 011.414 0L10 6.586l2.293-2.293a1 1 0 111.414 1.414L11.414 8l2.293 2.293a1 1 0 11-1.414 1.414L10 9.414l-2.293 2.293a1 1 0 11-1.414-1.414L8.586 8 6.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div
                        id="tooltip-remove-${item.id}"
                        role="tooltip"
                        class="shadow-xs tooltip z-40 inline-block rounded-lg bg-red-800 px-3 py-2 text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700"
                    >
                        Remover bien
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </td>
            `;
                            selectedTableBody.appendChild(selectedRow);

                            initializeTooltips();

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

                    function initializeTooltips() {
                        const tooltipTriggerList = document.querySelectorAll('[data-tooltip-target]');
                        tooltipTriggerList.forEach((tooltipTriggerEl) => {
                            const targetId = tooltipTriggerEl.getAttribute('data-tooltip-target');
                            const tooltipEl = document.getElementById(targetId);
                            if (tooltipEl) {
                                new Tooltip(tooltipEl, tooltipTriggerEl);
                            }
                            console.log(tooltipEl, tooltipTriggerEl);
                        });
                    }

                    tipoBienSelect.addEventListener('change', fetchData);
                    nombreBusquedaInput.addEventListener('input', () => {
                        clearTimeout(timeout);
                        timeout = setTimeout(fetchData, 500);
                    });

                    fetchData();
                });
            </script>

            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Código</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Nombre</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Descripción</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-500">Acciones</th>
                    </tr>
                </thead>
                <tbody id="bienes-table-body"></tbody>
            </table>
        </div>
    </div>

    <div class="mt-8">
        <span class="text-gray-600">Registros seleccionados</span>
        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Código</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Nombre</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Descripción</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-500">Acciones</th>
                    </tr>
                </thead>
                <tbody id="selected-bienes-table-body">
                    <!-- Selected rows will be populated here by JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <input hidden id="id_bienes" name="id_bienes" value="[]" />
</div>
