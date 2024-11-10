<x-app-layout>
    <x-slot name="header">
        <div class="p-6 text-2xl font-bold text-red-900 dark:text-gray-100">
            {{ __('Detalle de reporte') }}
        </div>
    </x-slot>

    <div class="mt-12 mb-8">
        <div class="flex flex-col lg:flex-row w-full">
            <!-- Columna izquierda (70%) -->
            <div class="w-full lg:w-[60%] px-8">
                <div class="mb-4">
                    <!-- Fila 1 -->
                    <div class="text-3xl font-bold ml-12 mb-8">
                        <p>{{ $reporte->titulo }}</p>
                    </div>
                </div>
                <div class="mb-4">
                    <!-- Fila 2 -->
                    <div class="font-semibold">
                        <div class="flex flex-row gap-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>
                            </svg>
                            Descripción
                        </div>
                        <div class="ml-12 mt-2">
                            <x-text-area id="descripcion" rows="8" :disabled="true">
                                {{ $reporte->descripcion }}
                            </x-text-area>
                        </div>

                    </div>
                </div>
                <div class="mb-4">
                    <!-- Fila 3 -->
                    <div class="font-semibold">
                        <div class="flex flex-row gap-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                            </svg>
                            Lugar
                        </div>
                        <div class="ml-12 mt-2">
                            <input type="text"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                   placeholder="Aula de ejemplo" value="{{ $reporte->aula?->nombre }}" disabled/>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Columna derecha (30%) -->
            <div class="w-full lg:w-[30%]">
                <div class="grid grid-cols-1 lg:grid-cols-2 grid-rows-8 lg:grid-rows-4 p-4">
                    <div><p class="text-gray-500 font-semibold">
                            Estado
                        </p></div>
                    <div>
                        <x-status.chips :text="$reporte->estado_ultimo_historial?->nombre ?? 'NO ASIGNADO'"
                                        class="mb-2"/>
                    </div>
                    <div><p class="text-gray-500 font-semibold">
                            Fecha
                        </p></div>
                    <div><p class="text-black font-semibold">
                            {{ \Carbon\Carbon::parse($reporte->fecha_reporte)->format('d/m/Y') }}
                        </p></div>
                    <div><p class="text-gray-500 font-semibold">
                            Hora
                        </p></div>
                    <div><p class="text-black font-semibold">
                            {{ \Carbon\Carbon::parse($reporte->hora_reporte)->format('h:i A') }}
                        </p></div>
                    <div><p class="text-gray-500 font-semibold">
                            Reportado <br/> por
                        </p></div>
                    <div><p class="text-black font-semibold">
                            {{ $reporte->usuarioReporta?->persona?->nombre }} {{ $reporte->usuarioReporta?->persona?->apellido }}
                        </p></div>
                </div>
            </div>
        </div>

        @if((!$reporte->estado_ultimo_historial?->nombre) && $reporte->no_procede == 0)
        
        <x-general.divider/>
            <form method="POST"
                  action="{{ route('reportes.realizarAsignacion', ['id' => $reporte->id]) }}"
                  enctype="multipart/form-data">
                @csrf
                <div class="flex flex-col lg:flex-row w-full mt-4">
                    <!-- Columna izquierda (70%) -->
                    <div class="w-full lg:w-[60%] px-8">
                        <div class="mb-4">
                            <!-- Fila 1 -->
                            <div class="text-xl font-bold ml-12 mb-8">
                                <p>Asignación</p>
                            </div>
                        </div>
                        <div class="mb-4">
                            <!-- Fila 2 -->
                            <div class="font-semibold">
                                <div class="flex flex-row gap-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z"/>
                                    </svg>
                                    Entidad
                                </div>
                                <div class="ml-12 mt-2">
                                    <select id="entidad"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                            onchange="location.href='?entidad=' + this.value">
                                        @foreach($entidades as $entidad)
                                            <option
                                                value="{{ $entidad->id }}" {{ $reporte->id_entidad == $entidad->id ? 'selected' : '' }}>{{ $entidad->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @foreach($empleadosPorEntidad as $empleado)
                                    <p>{{ $empleado['nombre_empleado'] }} {{ $empleado['apellido_empleado'] }}</p>
                                @endforeach

                            </div>
                        </div>
                        <div class="mb-4">
                            <!-- Fila 3 -->
                            <div class="font-semibold">
                                <div class="flex flex-row gap-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                                    </svg>
                                    Asignado a

                                    <button
                                        id="fetchData"
                                        class="bg-white text-black border border-black px-5 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="-2 -2 30 30"
                                             stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="ml-12 mt-2">
                                    <script>
                                        let selectedId;
                                        let selectedEmployees = [];
                                        let id_empleados_puestos = [];

                                        document.getElementById('entidad').addEventListener('change', function () {
                                            selectedId = this.value;
                                            selectedEmployees = [];
                                            id_empleados_puestos = [];
                                            renderSelectedEmployeesTable();
                                            document.getElementById('tableContainer').innerHTML = '';
                                            document.getElementById('noResultsLabel').style.display = 'none';
                                            fetchData(); // Llamar a fetchData cuando cambia la entidad
                                        });

                                        document.getElementById('fetchData').addEventListener('click', fetchData);

                                        function fetchData() {
                                            document.getElementById('nombreEmpleadoContainer').style.display = 'block';
                                            const nombreEmpleado = document.getElementById('nombreEmpleado').value;
                                            const url = `/rhu/busqueda-por-nombre/${selectedId}?nombre_empleado=${encodeURIComponent(nombreEmpleado)}`;

                                            fetch(url)
                                                .then(response => response.json())
                                                .then(data => {
                                                    const tableContainer = document.getElementById('tableContainer');
                                                    const noResultsLabel = document.getElementById('noResultsLabel');
                                                    tableContainer.innerHTML = ''; // Clear previous content if exists

                                                    if (data.status === 200 && data.lista_empleados.length > 0) {
                                                        noResultsLabel.style.display = 'none'; // Hide no results label if there are results
                                                        const title = document.createElement('h2');
                                                        title.textContent = 'Resultados de búsqueda';
                                                        title.classList.add('text-xl', 'font-bold', 'mb-4');
                                                        tableContainer.appendChild(title);

                                                        const table = document.createElement('table');
                                                        table.classList.add('table-auto', 'w-full', 'text-left', 'border-collapse');

                                                        const thead = document.createElement('thead');
                                                        const headerRow = document.createElement('tr');
                                                        ['Nombre', 'Puesto', 'Email', 'Acción'].forEach(text => {
                                                            const th = document.createElement('th');
                                                            th.classList.add('px-4', 'py-2', 'border');
                                                            th.textContent = text;
                                                            headerRow.appendChild(th);
                                                        });
                                                        thead.appendChild(headerRow);
                                                        table.appendChild(thead);

                                                        const tbody = document.createElement('tbody');
                                                        data.lista_empleados.forEach(empleado => {
                                                            const row = document.createElement('tr');
                                                            ['nombre_empleado', 'nombre_puesto', 'email'].forEach(key => {
                                                                const td = document.createElement('td');
                                                                td.classList.add('px-4', 'py-2', 'border');
                                                                td.textContent = empleado[key];
                                                                row.appendChild(td);
                                                            });

                                                            const actionTd = document.createElement('td');
                                                            actionTd.classList.add('px-4', 'py-2', 'border');
                                                            const assignButton = document.createElement('button');
                                                            assignButton.textContent = 'Asignar';
                                                            assignButton.classList.add('bg-blue-500', 'text-white', 'px-4', 'py-2', 'rounded');
                                                            assignButton.addEventListener('click', () => {
                                                                if (!selectedEmployees.some(e => e.id_empleado_puesto === empleado.id_empleado_puesto)) {
                                                                    selectedEmployees.push(empleado);
                                                                    id_empleados_puestos.push(empleado.id_empleado_puesto);
                                                                    renderSelectedEmployeesTable();
                                                                } else {
                                                                    alert('Este empleado ya ha sido seleccionado.');
                                                                }
                                                            });
                                                            actionTd.appendChild(assignButton);
                                                            row.appendChild(actionTd);

                                                            tbody.appendChild(row);
                                                        });
                                                        table.appendChild(tbody);

                                                        tableContainer.appendChild(table);
                                                    } else {
                                                        noResultsLabel.style.display = 'block'; // Show no results label if no results
                                                        console.error('No se encontraron resultados.');
                                                    }
                                                })
                                                .catch(error => console.error('Error:', error));
                                        }

                                        function renderSelectedEmployeesTable() {
                                            const selectedTableContainer = document.getElementById('selectedTableContainer');
                                            selectedTableContainer.innerHTML = ''; // Clear previous content if exists

                                            const title = document.createElement('h2');
                                            title.textContent = 'Empleados Seleccionados';
                                            title.classList.add('text-xl', 'font-bold', 'mb-4');
                                            selectedTableContainer.appendChild(title);

                                            const table = document.createElement('table');
                                            table.classList.add('table-auto', 'w-full', 'text-left', 'border-collapse');

                                            const thead = document.createElement('thead');
                                            const headerRow = document.createElement('tr');
                                            ['Nombre', 'Puesto', 'Email', 'Acción'].forEach(text => {
                                                const th = document.createElement('th');
                                                th.classList.add('px-4', 'py-2', 'border');
                                                th.textContent = text;
                                                headerRow.appendChild(th);
                                            });
                                            thead.appendChild(headerRow);
                                            table.appendChild(thead);

                                            const tbody = document.createElement('tbody');
                                            selectedEmployees.forEach((empleado, index) => {
                                                const row = document.createElement('tr');
                                                ['nombre_empleado', 'nombre_puesto', 'email'].forEach(key => {
                                                    const td = document.createElement('td');
                                                    td.classList.add('px-4', 'py-2', 'border');
                                                    td.textContent = empleado[key];
                                                    row.appendChild(td);
                                                });

                                                const actionTd = document.createElement('td');
                                                actionTd.classList.add('px-4', 'py-2', 'border');
                                                const removeButton = document.createElement('button');
                                                removeButton.textContent = 'Eliminar';
                                                removeButton.classList.add('bg-red-500', 'text-white', 'px-4', 'py-2', 'rounded');
                                                removeButton.addEventListener('click', () => {
                                                    selectedEmployees.splice(index, 1);
                                                    id_empleados_puestos.splice(id_empleados_puestos.indexOf(empleado.id_empleado_puesto), 1);
                                                    renderSelectedEmployeesTable();
                                                });
                                                actionTd.appendChild(removeButton);
                                                row.appendChild(actionTd);

                                                tbody.appendChild(row);
                                            });
                                            table.appendChild(tbody);

                                            selectedTableContainer.appendChild(table);
                                        }
                                    </script>

                                    <div id="noResultsLabel" style="display: none;" class="text-red-500 font-bold mt-4">
                                        No se encontraron resultados
                                    </div>

                                    <div class="mt-4" id="nombreEmpleadoContainer" style="display: none;">
                                        <input type="text" id="nombreEmpleado" placeholder="Nombre del empleado"
                                               class="border p-2 rounded">
                                    </div>
                                    <div id="tableContainer" class="mt-4"></div>
                                    <div id="selectedTableContainer" class="mt-4"></div>
                                </div>

                            </div>
                        </div>
                        <div class="mb-4">
                            <!-- Fila 3 -->
                            <div class="font-semibold">
                                <div class="flex flex-row gap-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                                    </svg>
                                    Supervisor

                                    <button
                                        id="fetchSupervisors"
                                        class="bg-white text-black border border-black px-5 ml-0.5 rounded">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="-2 -2 30 30"
                                             stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="ml-12 mt-2">
                                    <script>
                                        let selectedSupervisors = [];
                                        let id_empleado_supervisor = null;

                                        document.getElementById('fetchSupervisors').addEventListener('click', fetchSupervisors);

                                        function fetchSupervisors() {
                                            document.getElementById('nombreSupervisorContainer').style.display = 'block';
                                            const nombreSupervisor = document.getElementById('nombreSupervisor').value;
                                            const url = `/rhu/busqueda-supervisor-por-nombre?nombre_empleado=${encodeURIComponent(nombreSupervisor)}`;

                                            fetch(url)
                                                .then(response => response.json())
                                                .then(data => {
                                                    const supervisorTableContainer = document.getElementById('supervisorTableContainer');
                                                    const noSupervisorResultsLabel = document.getElementById('noSupervisorResultsLabel');
                                                    supervisorTableContainer.innerHTML = ''; // Clear previous content if exists

                                                    if (data.status === 200 && data.lista_supervisores.length > 0) {
                                                        noSupervisorResultsLabel.style.display = 'none'; // Hide no results label if there are results
                                                        const title = document.createElement('h2');
                                                        title.textContent = 'Resultados de búsqueda de supervisores';
                                                        title.classList.add('text-xl', 'font-bold', 'mb-4');
                                                        supervisorTableContainer.appendChild(title);

                                                        const table = document.createElement('table');
                                                        table.classList.add('table-auto', 'w-full', 'text-left', 'border-collapse');

                                                        const thead = document.createElement('thead');
                                                        const headerRow = document.createElement('tr');
                                                        ['Nombre', 'Puesto', 'Email', 'Acción'].forEach(text => {
                                                            const th = document.createElement('th');
                                                            th.classList.add('px-4', 'py-2', 'border');
                                                            th.textContent = text;
                                                            headerRow.appendChild(th);
                                                        });
                                                        thead.appendChild(headerRow);
                                                        table.appendChild(thead);

                                                        const tbody = document.createElement('tbody');
                                                        data.lista_supervisores.forEach(supervisor => {
                                                            const row = document.createElement('tr');
                                                            ['nombre_empleado', 'nombre_puesto', 'email'].forEach(key => {
                                                                const td = document.createElement('td');
                                                                td.classList.add('px-4', 'py-2', 'border');
                                                                td.textContent = supervisor[key];
                                                                row.appendChild(td);
                                                            });

                                                            const actionTd = document.createElement('td');
                                                            actionTd.classList.add('px-4', 'py-2', 'border');
                                                            const assignButton = document.createElement('button');
                                                            assignButton.textContent = 'Asignar';
                                                            assignButton.classList.add('bg-blue-500', 'text-white', 'px-4', 'py-2', 'rounded');
                                                            assignButton.addEventListener('click', () => {
                                                                selectedSupervisors = [supervisor];
                                                                id_empleado_supervisor = supervisor.id_empleado_puesto;
                                                                renderSelectedSupervisorsTable();
                                                            });
                                                            actionTd.appendChild(assignButton);
                                                            row.appendChild(actionTd);

                                                            tbody.appendChild(row);
                                                        });
                                                        table.appendChild(tbody);

                                                        supervisorTableContainer.appendChild(table);
                                                    } else {
                                                        noSupervisorResultsLabel.style.display = 'block'; // Show no results label if no results
                                                        console.error('No se encontraron resultados.');
                                                    }
                                                })
                                                .catch(error => console.error('Error:', error));
                                        }

                                        function renderSelectedSupervisorsTable() {
                                            const selectedSupervisorTableContainer = document.getElementById('selectedSupervisorTableContainer');
                                            selectedSupervisorTableContainer.innerHTML = ''; // Clear previous content if exists

                                            const title = document.createElement('h2');
                                            title.textContent = 'Supervisores Seleccionados';
                                            title.classList.add('text-xl', 'font-bold', 'mb-4');
                                            selectedSupervisorTableContainer.appendChild(title);

                                            const table = document.createElement('table');
                                            table.classList.add('table-auto', 'w-full', 'text-left', 'border-collapse');

                                            const thead = document.createElement('thead');
                                            const headerRow = document.createElement('tr');
                                            ['Nombre', 'Puesto', 'Email', 'Acción'].forEach(text => {
                                                const th = document.createElement('th');
                                                th.classList.add('px-4', 'py-2', 'border');
                                                th.textContent = text;
                                                headerRow.appendChild(th);
                                            });
                                            thead.appendChild(headerRow);
                                            table.appendChild(thead);

                                            const tbody = document.createElement('tbody');
                                            selectedSupervisors.forEach((supervisor, index) => {
                                                const row = document.createElement('tr');
                                                ['nombre_empleado', 'nombre_puesto', 'email'].forEach(key => {
                                                    const td = document.createElement('td');
                                                    td.classList.add('px-4', 'py-2', 'border');
                                                    td.textContent = supervisor[key];
                                                    row.appendChild(td);
                                                });

                                                const actionTd = document.createElement('td');
                                                actionTd.classList.add('px-4', 'py-2', 'border');
                                                const removeButton = document.createElement('button');
                                                removeButton.textContent = 'Eliminar';
                                                removeButton.classList.add('bg-red-500', 'text-white', 'px-4', 'py-2', 'rounded');
                                                removeButton.addEventListener('click', () => {
                                                    selectedSupervisors = [];
                                                    id_empleado_supervisor = null;
                                                    renderSelectedSupervisorsTable();
                                                });
                                                actionTd.appendChild(removeButton);
                                                row.appendChild(actionTd);

                                                tbody.appendChild(row);
                                            });
                                            table.appendChild(tbody);

                                            selectedSupervisorTableContainer.appendChild(table);
                                        }
                                    </script>

                                    <div id="noSupervisorResultsLabel" style="display: none;"
                                         class="text-red-500 font-bold mt-4">
                                        No se encontraron resultados
                                    </div>

                                    <div class="mt-4" id="nombreSupervisorContainer" style="display: none;">
                                        <input type="text" id="nombreSupervisor" placeholder="Nombre del supervisor"
                                               class="border p-2 rounded">
                                    </div>
                                    <div id="supervisorTableContainer" class="mt-4"></div>
                                    <div id="selectedSupervisorTableContainer" class="mt-4"></div>
                                </div>

                            </div>
                        </div>
                        <div class="mb-4">
                            <!-- Fila 2 -->
                            <div class="font-semibold">
                                <div class="flex flex-row gap-6">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5"
                                         stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/>
                                    </svg>
                                    Comentario de administración
                                </div>
                                <div class="ml-12 mt-2">
                                    <x-text-area id="comentario" rows="8" :disabled="false">
                                    </x-text-area>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Columna derecha (30%) -->
                    <div class="w-full lg:w-[25%]">
                        <button id="marcarNoProcede"
                                class="bg-red-700 text-white text-sm py-2 px-4 rounded hover:bg-red-500"
                                x-data
                                x-on:click="$dispatch('open-modal', 'confirm-modal')">
                            Marcar como No procede
                        </button>

                        <x-modal name="confirm-modal" :show="false" maxWidth="md">
                            <div class="p-6">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    Confirmación
                                </h2>
                                <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                                    ¿Estás seguro de que deseas marcar este reporte como "No procede"?
                                </p>
                            </div>
                            <div class="flex justify-end px-6 py-4 bg-gray-100 dark:bg-gray-800 text-right">
                                <button
                                    class="bg-gray-500 text-white px-4 py-2 rounded"
                                    x-on:click="$dispatch('close-modal', 'confirm-modal')">
                                    Cancelar
                                </button>
                                <button
                                    id="confirmMarcarNoProcede"
                                    class="bg-red-700 text-white px-4 py-2 rounded ml-2">
                                    Confirmar
                                </button>
                            </div>
                        </x-modal>

                        <script>
                            document.getElementById('confirmMarcarNoProcede').addEventListener('click', function () {
                                const idReporte = window.location.pathname.split('/').pop(); // Obtener el ID del reporte desde la URL

                                axios.put(`/reportes/marcar-no-procede/${idReporte}`, {}, {
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    }
                                })
                                    .then(response => {
                                        if (response.data.message) {
                                            alert(response.data.message);
                                        }
                                        window.location.reload();
                                    })
                                    .catch(error => console.error('Error:', error));
                            });
                        </script>
                    </div>
                </div>
                <div class="flex flex-col lg:flex-row w-full justify-center mt-8">
                    <button id="enviarAsignacion"
                            class="bg-escarlata-ues text-white text-sm py-2 px-4 rounded hover:bg-red-700">
                        Enviar Asignación
                    </button>

                    <script>
                        document.getElementById('enviarAsignacion').addEventListener('click', function () {
                            const idEntidad = document.getElementById('entidad').value;
                            const comentario = document.getElementById('comentario').value;
                            const idReporte = window.location.pathname.split('/').pop(); // Obtener el ID del reporte desde la URL

                            // Validaciones
                            if (!idEntidad || isNaN(idEntidad)) {
                                alert('Por favor, seleccione una entidad válida.');
                                return;
                            }
                            if (!id_empleados_puestos.length) {
                                alert('Por favor, seleccione al menos un empleado.');
                                return;
                            }
                            if (!id_empleado_supervisor) {
                                alert('Por favor, seleccione un supervisor.');
                                return;
                            }

                            const body = {
                                id_empleados_puestos: id_empleados_puestos,
                                comentario: comentario,
                                id_entidad: parseInt(idEntidad),
                                id_empleado_supervisor: id_empleado_supervisor
                            };

                            fetch(`/reportes/realizar-asignacion/${idReporte}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify(body)
                            })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.message) {
                                        alert(data.message);
                                        window.location.reload();
                                    } else {
                                        alert('Asignación realizada con éxito.');
                                        window.location.reload();
                                    }
                                })
                                .catch(error => console.error('Error:', error));
                        });
                    </script>
                </div>
            </form>
        @endif
        @if ($reporte->accionesReporte)

        <x-general.divider/>
        <div class="flex flex-col lg:flex-row w-full">
            <!-- Columna izquierda (80%) -->
            <div class="w-full lg:w-[80%] px-8">
                {{--                Espacio para el timeline--}}
                <div class="mt-4"></div>
                <div class="mb-4">
                    <!-- Fila 1 -->
                    <div class="text-xl font-bold ml-12 mb-8">
                        <p>Historial</p>
                    </div>
                </div>
                @foreach ($reporte->accionesReporte->historialAccionesReporte as $historial)
                <ol class="relative mx-2 border-gray-200 dark:border-gray-700">
                    <li class="mb-10 ms-4">
                        <div
                            class="absolute -start-1.5 mt-1.5 h-3 w-3 rounded-full border border-white bg-gray-200 dark:border-gray-900 dark:bg-gray-700"
                        ></div>
                        <div class="mb-2">
                            <x-status.chips :text="$historial->estado->nombre" class="mb-2" />
                        </div>
                        <div class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">
                            {{ \Carbon\Carbon::parse($historial->fecha_actualizacion)->format('d/m/Y') . '  ' . \Carbon\Carbon::parse($historial->hora_actualizacion)->format('h:i A') }}
                        </div>
                        @if ($historial->comentario)
                            <h3 class="text-lg font-semibold text-red-900 dark:text-white">Comentarios</h3>
                            <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
                                {{ $historial->comentario }}
                            </p>
                        @endif
    
                        @if ($historial->foto_evidencia)
                            <a
                                href="#"
                                class="inline-flex items-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:text-blue-700 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700"
                            >
                                Evidencia
                                <svg
                                    class="ms-2 h-3 w-3 rtl:rotate-180"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 14 10"
                                >
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M1 5h12m0 0L9 1m4 4L9 9"
                                    />
                                </svg>
                            </a>
                        @endif
    
                        <div class="block items-center p-3 hover:bg-gray-100 dark:hover:bg-gray-700 sm:flex">
                            <img
                                class="mb-3 me-3 h-8 w-8 rounded-full sm:mb-0"
                                src="/storage/reportes/evidencia/uo274RP1t9Rth2VkWYatbMB8Qmz2oHkNzOkcqIkr.jpg"
                                alt="Jese Leos image"
                            />
                            <div class="text-gray-600 dark:text-gray-400">
                                @php
                                    $persona = $historial->empleadoPuesto->usuario->persona;
                                @endphp
                                <div class="text-sm font-normal">{{ $persona->nombre . ' ' . $persona->apellido }}</div>
                            </div>
                        </div>
                    </li>
                </ol>
            @endforeach

                
            </div>
            <div class="w-full lg:w-[20%] px-8">
                <button id="abrirActualizarSeguimiento"
                        class="bg-escarlata-ues text-white text-sm py-2 px-4 rounded hover:bg-red-500 flex items-center"
                        x-data
                        x-on:click="$dispatch('open-modal', 'actualizar-seguimiento-modal')">
                    <p class="mr-2">Actualizar</p>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5"/>
                    </svg>
                </button>



                <x-modal name="actualizar-seguimiento-modal" :show="false" maxWidth="xl">
                    <form method="POST"
                          action="{{ route('reportes.actualizarEstado', ['id' => $reporte->id]) }}"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="p-6 flex flex-col items-center w-full">
                            <h2 class="text-lg font-medium text-escarlata-ues dark:text-gray-100">
                                Actualizar seguimiento de reporte
                            </h2>
                            <div class="mt-4 w-full">
                                <label for="id_estado"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">Actualizar
                                    a</label>
                                <select id="id_estado" name="id_estado"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Seleccionar estado</option>
                                    @foreach($estadosPermitidos as $estado)
                                        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                                    @endforeach
                                </select>
                                @include('components.forms.input-error', ['messages' => $errors->get('id_estado')])
                            </div>
                            <div class="mt-4 w-full">
                                <label for="comentarios"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">Comentarios</label>
                                <textarea id="comentarios" name="comentario" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                @include('components.forms.input-error', ['messages' => $errors->get('comentario')])
                            </div>
                            <div class="mt-4 w-full">
                                <label for="evidencia"
                                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">Evidencia</label>
                                <input type="file" id="evidencia" name="evidencia"
                                       class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 rounded-md cursor-pointer focus:outline-none focus:border-indigo-500 focus:ring-indigo-500">
                                @include('components.forms.input-error', ['messages' => $errors->get('evidencia')])
                            </div>
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
            </div>
        </div>
        @endif
    </div>


</x-app-layout>
