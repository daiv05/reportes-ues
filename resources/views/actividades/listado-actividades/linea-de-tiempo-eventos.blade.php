@php
    $headers = [
        ['text' => 'Actividad', 'align' => 'left'],
        ['text' => 'Asignatura', 'align' => 'left'],
        ['text' => 'Aula', 'align' => 'left'],
        ['text' => 'Modalidad', 'align' => 'left'],
        ['text' => 'Fecha', 'align' => 'left'],
        ['text' => 'Horario', 'align' => 'left'],
        ['text' => 'Estado', 'align' => 'center'],
        ['text' => 'Acciones', 'align' => 'left'],
    ];

    $cicloActivo = \App\Models\Mantenimientos\Ciclo::with('tipoCiclo')
        ->where('activo', 1)
        ->first();
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.main
            tituloMenor="Línea de tiempo de actividades"
            tituloMayor="DE LA FACULTAD {{ isset($cicloActivo) ? 'CICLO ' . ($cicloActivo->tipoCiclo->nombre === 'SEGUNDO' ? 'II' : 'I') . ' - ' . $cicloActivo->anio : '' }}"
            subtitulo="Mantente pendiente de los ultimos reportes notificados de tu facultad"
        >
            <x-slot name="acciones">
                <div class="flex flex-wrap gap-3">
                    {{-- <x-button-redirect to="listado-eventos-evaluaciones" label="Regresar" /> --}}
                    <a
                        href="{{ url()->previous() }}"
                        class="inline-flex items-center rounded-md border border-transparent bg-escarlata-ues px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-escarlata-ues focus:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-900 dark:hover:bg-white dark:focus:bg-white dark:focus:ring-offset-red-800 dark:active:bg-red-300"
                    >
                        Regresar
                    </a>
                </div>
            </x-slot>
        </x-header.main>
    </x-slot>

    <x-container>
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul
                class="-mb-px flex flex-wrap text-center text-sm font-medium"
                id="default-styled-tab"
                data-tabs-toggle="#default-styled-tab-content"
                data-tabs-active-classes="text-escarlata-ues hover:text-orange-950 dark:text-escrlata-ues dark:hover:text-orange-700 border-escarlata-ues dark:border-escarlata-ues"
                data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300"
                role="tablist"
            >
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block rounded-t-lg border-b-2 p-4"
                        id="profile-styled-tab"
                        data-tabs-target="#styled-profile"
                        type="button"
                        role="tab"
                        aria-controls="profile"
                        aria-selected="false"
                    >
                        Eventos y evaluaciones del ciclo
                    </button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block rounded-t-lg border-b-2 p-4 hover:border-gray-300 hover:text-gray-600 dark:hover:text-gray-300"
                        id="dashboard-styled-tab"
                        data-tabs-target="#styled-dashboard"
                        type="button"
                        role="tab"
                        aria-controls="dashboard"
                        aria-selected="false"
                    >
                        Actividades de una fecha
                    </button>
                </li>
            </ul>
        </div>
        <div id="default-styled-tab-content">
            <div
                class="hidden h-fit rounded-lg bg-gray-50 p-4 dark:bg-gray-800"
                id="styled-profile"
                role="tabpanel"
                aria-labelledby="profile-tab"
            >
                <div class="mx-auto max-w-4xl">
                    <h1 class="mb-8 text-center text-3xl font-bold text-orange-900">
                        Línea de Tiempo de Eventos y evaluaciones
                    </h1>

                    <div class="relative">
                        <!-- Línea central de tiempo -->
                        <div id="line" class="absolute left-1/2 h-full w-1 -translate-x-1/2 transform bg-escarlata-ues">
                            <div
                                class="absolute left-1/2 top-0 h-4 w-4 -translate-x-1/2 -translate-y-1/2 transform rounded-full bg-orange-900"
                            ></div>
                            <div
                                class="absolute bottom-0 left-1/2 h-4 w-4 -translate-x-1/2 translate-y-1/2 transform rounded-full bg-orange-900"
                            ></div>
                        </div>

                        <!-- Contenedor dinámico de eventos -->
                        <div id="eventos-container" class="space-y-9"></div>

                        <!-- Botón para cargar más -->
                        <div class="mt-7 text-center">
                            <button
                                id="cargarMas"
                                class="absolute bottom-0 left-1/2 z-20 flex h-9 w-28 -translate-x-1/2 translate-y-1/2 transform justify-center rounded-lg bg-orange-900 px-4 py-1 text-white"
                            >
                                Cargar más
                            </button>
                        </div>

                        <!-- Mensaje en caso que no haya registros -->
                        <div id="no-eventos" class="hidden w-full items-center justify-center py-3">
                            <p class="text-center text-gray-500 dark:text-gray-400">
                                No hay eventos ni evaluaciones registrados en el ciclo actual.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="hidden rounded-lg bg-gray-50 p-4 dark:bg-gray-800"
                id="styled-dashboard"
                role="tabpanel"
                aria-labelledby="dashboard-tab"
            >
                <div class="mx-auto max-w-4xl">
                    <h1 id="actividades-timeline-titulo" class="mb-8 text-center text-3xl font-bold text-orange-900">
                        Línea de Tiempo de actividades del día
                    </h1>

                    <div class="flex flex-wrap items-center justify-center gap-4">
                        <label for="fecha" class="text-gray-600 dark:text-gray-400">Selecciona una fecha:</label>
                        <div class="max-w-xs">
                            <x-forms.date-input
                                id="fecha"
                                type="date"
                                name="fecha-actividades"
                                :value="request('fecha-actividades')"
                                class="mt-1 w-full"
                            />
                        </div>
                        <button
                            id="buscarActividades"
                            class="h-9 rounded-lg bg-orange-900 px-4 py-1 text-white"
                            onclick="cargarActividades(true)"
                        >
                            Buscar
                        </button>
                    </div>

                    <div id="timeline-container-actividades" class="relative my-8 hidden">
                        <!-- Línea central de tiempo -->
                        <div
                            id="line-actividades"
                            class="absolute left-1/2 h-full w-1 -translate-x-1/2 transform bg-escarlata-ues"
                        >
                            <div
                                class="absolute left-1/2 top-0 h-4 w-4 -translate-x-1/2 -translate-y-1/2 transform rounded-full bg-orange-900"
                            ></div>
                            <div
                                class="absolute bottom-0 left-1/2 h-4 w-4 -translate-x-1/2 translate-y-1/2 transform rounded-full bg-orange-900"
                            ></div>
                        </div>

                        <!-- Contenedor dinámico de actividades -->
                        <div id="actividades-container" class="w-full space-y-9"></div>

                        <!-- Botón para cargar más -->
                        <div class="mt-7 text-center">
                            <button
                                id="cargarMasActividades"
                                class="absolute bottom-0 left-1/2 z-20 flex h-9 w-28 -translate-x-1/2 translate-y-1/2 transform justify-center rounded-lg bg-orange-900 px-4 py-1 text-white"
                                onclick="cargarActividades(false)"
                            >
                                Cargar más
                            </button>
                        </div>

                        <!-- Mensaje en caso que no haya registros -->
                        <div id="no-actividades" class="hidden w-full items-center justify-center py-3">
                            <p class="text-center text-gray-500 dark:text-gray-400">
                                No hay actividades asignadas para este día.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-container>
</x-app-layout>

<script>
    let page = 1;
    const eventosContainer = document.getElementById('eventos-container');
    const line = document.getElementById('line');
    const noEventos = document.getElementById('no-eventos');
    const cargarMasBtn = document.getElementById('cargarMas');

    let pageActividades = 1;
    let urlActividades = `/actividades/eventos-y-evaluaciones/linea-de-tiempo/obtener-actividades?page=${pageActividades}`;
    const tituloActividades = document.getElementById('actividades-timeline-titulo');
    const actividadesContainer = document.getElementById('actividades-container');
    const noActividades = document.getElementById('no-actividades');
    const cargarMasActividadesBtn = document.getElementById('cargarMasActividades');
    const lineActividades = document.getElementById('line-actividades');
    const timelineContainerActividades = document.getElementById('timeline-container-actividades');

    function formatearFecha(dateString) {
        const fecha = new Date(dateString);
        return new Intl.DateTimeFormat('es-ES', { day: 'numeric', month: 'long', year: 'numeric' }).format(fecha);
    }

    function convertirHora12H(hora) {
        if (!hora) return '';
        let [horas, minutos] = hora.split(':').map(Number);
        let periodo = horas >= 12 ? 'PM' : 'AM';

        // Convertir a formato de 12 horas
        horas = horas % 12 || 12;

        return `${horas.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')} ${periodo}`;
    }
    function formatName(name) {
        return name
            .toLowerCase() // Convertimos todo a minúsculas
            .split(' ') // Dividimos por espacios
            .map((word) => word.charAt(0).toUpperCase() + word.slice(1)) // Capitalizamos la primera letra
            .join(' '); // Unimos nuevamente las palabras
    }

    async function cargarEventos() {
        try {
            cargarMasBtn.disabled = true;

            cargarMasBtn.innerHTML = `<div class="loader mt-1"></div>`;

            const response = await fetch(
                `/actividades/eventos-y-evaluaciones/linea-de-tiempo/obtener-eventos?page=${page}`,
            );
            const data = await response.json();

            if (data.data.length === 0) {
                cargarMasBtn.style.display = 'none';
                line.style.display = 'none';

                noEventos.classList.remove('hidden');
                noEventos.classList.add('flex');
                return;
            }

            data.data.forEach((evento, index) => {
                const posicion = (index + 1 + (page - 1) * 5) % 2 === 0 ? 'right' : 'left';
                const eventoHTML = `
                    <div class="relative flex items-center w-full">
                        ${
                            posicion === 'left'
                                ? `
                            <div class="w-5/12 flex justify-end">
                                <div class="bg-white p-4 rounded-lg shadow-lg w-full relative hover:shadow-xl border-l-4 border-orange-900">
                                    <div class="w-full flex justify-end items-center mb-1">
                                        <span class="text-xs text-orange-900 font-semibold bg-orange-900/10 px-2 py-1 rounded-full">${formatearFecha(evento.fecha)}</span>
                                    </div>
                                    <h3 class="text-base font-bold text-orange-900">${evento.descripcion}</h3>
                                    <p class="text-gray-600 text-sm">${evento.actividad.asignaturas[0].nombre} - ${evento.actividad.asignaturas[0].nombre_completo}</p>
                                </div>
                            </div>
                        `
                                : `<div class="w-5/12"></div>`
                        }
                        <div class="w-2/12 flex justify-center">
                            <div class="w-10 h-10 bg-orange-900 rounded-full flex items-center justify-center shadow-lg border-4 border-white">
                                <span class="text-white text-sm font-bold">${index + 1 + (page - 1) * 5}</span>
                            </div>
                        </div>
                        ${
                            posicion === 'right'
                                ? `
                            <div class="w-5/12 flex justify-start">
                                <div class="bg-white p-4 rounded-lg shadow-lg w-full relative hover:shadow-xl border-l-4 border-orange-900">
                                    <div class="w-full flex justify-end items-center mb-1">
                                        <span class="text-xs text-orange-900 font-semibold bg-orange-900/10 px-2 py-1 rounded-full">${formatearFecha(evento.fecha)}</span>
                                    </div>
                                    <h3 class="text-base font-bold text-orange-900">${evento.descripcion}</h3>
                                    <p class="text-gray-600 text-sm">${evento.actividad.asignaturas[0].nombre} - ${evento.actividad.asignaturas[0].nombre_completo}</p>
                                </div>
                            </div>
                        `
                                : `<div class="w-5/12"></div>`
                        }
                    </div>
                `;
                eventosContainer.innerHTML += eventoHTML;
            });

            if (data.next_page_url) {
                page++;
            } else {
                cargarMasBtn.style.display = 'none';
            }

            cargarMasBtn.disabled = false;
            cargarMasBtn.innerHTML = 'Cargar más';
            cargarMasBtn.blur();
        } catch (error) {
            console.error('Error al cargar eventos:', error);
        }
    }

    async function cargarActividades(firstLoad = false) {
        try {
            cargarMasActividadesBtn.disabled = true;

            if (firstLoad) {
                pageActividades = 1;
                urlActividades = `/actividades/eventos-y-evaluaciones/linea-de-tiempo/obtener-actividades?page=${pageActividades}&fecha-actividades=${document.getElementById('fecha').value}`;
                actividadesContainer.innerHTML = '';
                actividadesContainer.display = 'none';
                cargarMasActividadesBtn.style.display = 'flex';
                noActividades.classList.remove('flex');
                noActividades.classList.add('hidden');

                actividadesContainer.classList.remove('hidden');

                lineActividades.style.display = 'flex';
            }

            tituloActividades.innerHTML = `Línea de Tiempo de actividades del día ${document.getElementById('fecha').value}`;

            cargarMasActividadesBtn.innerHTML = `<div class="loader mt-1"></div>`;

            if (document.getElementById('fecha').value) {
                timelineContainerActividades.classList.remove('hidden');
                timelineContainerActividades.classList.add('flex');
            }

            const response = await fetch(urlActividades);
            const data = await response.json();

            if (data.data.length === 0) {
                lineActividades.style.display = 'none';
                actividadesContainer.classList.add('hidden');
                cargarMasActividadesBtn.style.display = 'none';

                noActividades.classList.remove('hidden');
                noActividades.classList.add('flex');
                return;
            }

            data.data.forEach((actividad, index) => {
                const posicion = (index + 1 + (pageActividades - 1) * 5) % 2 === 0 ? 'right' : 'left';
                const actividadHTML = `
                    <div class="relative flex items-center w-full">
                        ${
                            posicion === 'left'
                                ? `
                            <div class="w-5/12 flex justify-end">
                                <div class="bg-white p-4 rounded-lg shadow-lg w-full relative hover:shadow-xl border-l-4 ${actividad.evento ? 'border-orange-900' : 'border-green-900'}">
                                    <div class="w-full flex justify-end items-center mb-1">
                                        <span class="text-xs text-blue-900 font-semibold bg-blue-100 px-2 py-1 rounded-full">${convertirHora12H(actividad.hora_inicio)} - ${convertirHora12H(actividad.hora_fin)}</span>
                                    </div>
                                    <h3 class="text-base font-bold text-orange-900">${actividad.evento ? formatName(actividad.evento.descripcion) : formatName(actividad.clase.tipo_clase.nombre) + ' ' + actividad.clase.numero_grupo}</h3>
                                    <p class="text-gray-600 text-sm">${actividad.asignaturas[0].nombre} - ${actividad.asignaturas[0].nombre_completo}</p>
                                </div>
                            </div>
                        `
                                : `<div class="w-5/12"></div>`
                        }
                        <div class="w-2/12 flex justify-center">
                            <div class="w-10 h-10 bg-orange-900 rounded-full flex items-center justify-center shadow-lg border-4 border-white">
                                <span class="text-white text-sm font-bold">${index + 1 + (pageActividades - 1) * 5}</span>
                            </div>
                        </div>
                        ${
                            posicion === 'right'
                                ? `
                            <div class="w-5/12 flex justify-start">
                                <div class="bg-white p-4 rounded-lg shadow-lg w-full relative hover:shadow-xl border-l-4 ${actividad.evento ? 'border-orange-900' : 'border-green-700'}">
                                    <div class="w-full flex justify-end items-center mb-1">
                                        <span class="text-xs text-blue-900 font-semibold bg-blue-100 px-2 py-1 rounded-full">${convertirHora12H(actividad.hora_inicio)} - ${convertirHora12H(actividad.hora_fin)}</span>
                                    </div>
                                    <h3 class="text-base font-bold text-orange-900">${actividad.evento ? formatName(actividad.evento.descripcion) : formatName(actividad.clase.tipo_clase.nombre) + ' ' + actividad.clase.numero_grupo}</h3>
                                    <p class="text-gray-600 text-sm">${actividad.asignaturas[0].nombre} - ${actividad.asignaturas[0].nombre_completo}</p>
                                </div>
                            </div>
                        `
                                : `<div class="w-5/12"></div>`
                        }
                    </div>
                `;
                actividadesContainer.innerHTML += actividadHTML;
            });

            if (data.next_page_url) {
                pageActividades++;
                urlActividades = data.next_page_url;
            } else {
                cargarMasActividadesBtn.style.display = 'none';
            }

            cargarMasActividadesBtn.disabled = false;
            cargarMasActividadesBtn.innerHTML = 'Cargar más';
            cargarMasActividadesBtn.blur();
        } catch (error) {
            console.error('Error al cargar actividades:', error);
        }
    }

    cargarMasBtn.addEventListener('click', cargarEventos);

    // Carga eventos automáticamente al hacer scroll
    // const observer = new IntersectionObserver(entries => {
    //     if (entries[0].isIntersecting) {
    //         cargarEventos();
    //     }
    // }, { threshold: 1.0 });

    // observer.observe(cargarMasBtn);

    // Cargar los primeros eventos al inicio
    cargarEventos();
</script>
