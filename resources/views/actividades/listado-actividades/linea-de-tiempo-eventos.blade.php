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
            tituloMenor="Listado de eventos"
            tituloMayor="DE LA FACULTAD {{ isset($cicloActivo) ? 'CICLO ' . ($cicloActivo->tipoCiclo->nombre === 'SEGUNDO' ? 'II' : 'I') . ' - ' . $cicloActivo->anio : '' }}"
            subtitulo="Mantente pendiente de los ultimos reportes notificados de tu facultad"
        >
            <x-slot name="acciones">
                <div class="flex flex-wrap gap-3">
                    <x-button-redirect to="listado-eventos-evaluaciones" label="Regresar" />
                </div>
            </x-slot>
        </x-header.main>
    </x-slot>

    <x-container>
        {{-- FILTROS --}}
        <div class="max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-orange-900 mb-8 text-center">Línea de Tiempo de Eventos y evaluaciones</h1>

            <div class="relative">
                <!-- Línea central de tiempo -->
                <div class="absolute left-1/2 transform -translate-x-1/2 w-1 h-full bg-escarlata-ues">
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-4 h-4 bg-orange-900 rounded-full"></div>
                    <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 w-4 h-4 bg-orange-900 rounded-full"></div>
                </div>

                <!-- Contenedor dinámico de eventos -->
                <div id="eventos-container" class="space-y-9"></div>

                <!-- Botón para cargar más -->
                <div class="text-center mt-7">
                    <button id="cargarMas" class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1/2 bg-orange-900 text-white w-28 h-9 px-4 py-1 rounded-lg z-20 flex justify-center">
                        Cargar más
                    </button>
                </div>
            </div>
        </div>

    </x-container>
</x-app-layout>

<script>
    let page = 1;
    const eventosContainer = document.getElementById("eventos-container");
    const cargarMasBtn = document.getElementById("cargarMas");

    function formatearFecha(dateString) {
        const fecha = new Date(dateString);
        return new Intl.DateTimeFormat('es-ES', { day: 'numeric', month: 'long', year: 'numeric' }).format(fecha);
    }

    async function cargarEventos() {
        try {
            cargarMasBtn.disabled = true;

            cargarMasBtn.innerHTML = `<div class="loader mt-1"></div>`;

            const response = await fetch(`/actividades/eventos-y-evaluaciones/linea-de-tiempo/obtener-eventos?page=${page}`);
            const data = await response.json();

            data.data.forEach((evento, index) => {
                const posicion = (index + 1 + (page - 1) * 5) % 2 === 0 ? 'right' : 'left';
                const eventoHTML = `
                    <div class="relative flex items-center w-full">
                        ${posicion === 'left' ? `
                            <div class="w-5/12 flex justify-end">
                                <div class="bg-white p-4 rounded-lg shadow-lg w-full relative hover:shadow-xl border-l-4 border-orange-900">
                                    <div class="w-full flex justify-end items-center mb-1">
                                        <span class="text-xs text-orange-900 font-semibold bg-orange-900/10 px-2 py-1 rounded-full">${ formatearFecha(evento.fecha) }</span>
                                    </div>
                                    <h3 class="text-base font-bold text-orange-900">${evento.descripcion}</h3>
                                    <p class="text-gray-600 text-sm">${evento.actividad.asignaturas[0].nombre} - ${evento.actividad.asignaturas[0].nombre_completo}</p>
                                </div>
                            </div>
                        ` : `<div class="w-5/12"></div>`}
                        <div class="w-2/12 flex justify-center">
                            <div class="w-10 h-10 bg-orange-900 rounded-full flex items-center justify-center shadow-lg border-4 border-white">
                                <span class="text-white text-sm font-bold">${index + 1 + (page - 1) * 5}</span>
                            </div>
                        </div>
                        ${posicion === 'right' ? `
                            <div class="w-5/12 flex justify-start">
                                <div class="bg-white p-4 rounded-lg shadow-lg w-full relative hover:shadow-xl border-l-4 border-orange-900">
                                    <div class="w-full flex justify-end items-center mb-1">
                                        <span class="text-xs text-orange-900 font-semibold bg-orange-900/10 px-2 py-1 rounded-full">${ formatearFecha(evento.fecha) }</span>
                                    </div>
                                    <h3 class="text-base font-bold text-orange-900">${evento.descripcion}</h3>
                                    <p class="text-gray-600 text-sm">${evento.actividad.asignaturas[0].nombre} - ${evento.actividad.asignaturas[0].nombre_completo}</p>
                                </div>
                            </div>
                        ` : `<div class="w-5/12"></div>`}
                    </div>
                `;
                eventosContainer.innerHTML += eventoHTML;
            });

            if (data.next_page_url) {
                page++;
            } else {
                cargarMasBtn.style.display = "none";
            }

            cargarMasBtn.disabled = false;
            cargarMasBtn.innerHTML = "Cargar más";
            cargarMasBtn.blur();
        } catch (error) {
            console.error("Error al cargar eventos:", error);
        }
    }

    cargarMasBtn.addEventListener("click", cargarEventos);

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


