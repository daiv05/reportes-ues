@php
    $headers = [
        ['text' => 'Asignatura', 'align' => 'left'],
        ['text' => 'Aula', 'align' => 'left'],
        ['text' => 'Modalidad', 'align' => 'left'],
        ['text' => 'Numero de grupo', 'align' => 'center'],
        ['text' => 'Escuela', 'align' => 'left'],
        ['text' => 'Horario', 'align' => 'left'],
        ['text' => 'Acciones', 'align' => 'left'],
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-header.main
            tituloMenor="Listado de"
            tituloMayor="CLASES DE LA FACULTAD"
            subtitulo="Mantente pendiente de los ultimos reportes notificados de tu facultad"
        >
            <x-slot name="acciones">
                <x-button-redirect to="reportes-generales" label="Ver listado de reportes" />
            </x-slot>
        </x-header.main>
    </x-slot>
    <div>
        {{-- FILTROS --}}
        <div class="flex-column flex flex-wrap items-center gap-3 space-y-4 pb-4 sm:flex-row sm:space-y-0">
            <div class="flex-col flex flex-wrap items-center justify-between space-y-4 pb-4 sm:flex-row sm:space-y-0">
                <form action="{{ route('listado-clases') }}" method="GET" class="flex-row flex space-x-8 mt-4">
                    <div class="relative">
                        <div
                            class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3 rtl:right-0">
                            <svg class="h-4 w-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                                 viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                      clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <input type="text" id="table-search" name="table-search" value="{{ request('table-search') }}"
                               class="block w-80 rounded-lg border border-gray-300 bg-gray-50 p-2 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                               placeholder="Buscar por materia"/>
                        </div>
                    </div>
                    <button type="submit"
                            class="align-middle rounded-full inline-flex items-center px-3 py-3 border border-transparent shadow-sm text-sm font-medium text-white bg-escarlata-ues hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                        </svg>
                    </button>

                    <button type="reset"
                            class="align-middle rounded-full inline-flex items-center px-3 py-3 shadow-sm text-sm font-medium bg-white border border-gray-500 text-gray-500 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                            onclick="window.location.href='{{ route('listado-clases') }}';">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="h-4 w-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </form>
            </div>
            {{-- TABLA --}}
            <x-table.base :headers="$headers" id="table-content">
                @foreach ($clases as $clase)
                    <x-table.tr>
                        <x-table.td>{{ $clase->actividad->asignaturas[0]->nombre }}</x-table.td>
                        <x-table.td>{{ $clase->actividad->aulas[0]->nombre }}</x-table.td>
                        <x-table.td>{{ $clase->actividad->modalidad->nombre }}</x-table.td>
                        <x-table.td>{{ $clase->numero_grupo }}</x-table.td>
                        <x-table.td>{{ $clase->actividad->asignaturas[0]->escuela->nombre }}</x-table.td>
                        <x-table.td>{{ $clase->actividad->hora_inicio. ' - '. $clase->actividad->hora_fin }}</x-table.td>
                        <x-table.td>
                            <a href="{{ route('crear-reporte') }}" class="font-medium text-gray-700 hover:underline">
                                <x-heroicon-s-flag class="mx-2 h-4" />
                            </a>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
            </x-table.base>
            <nav
                class="flex-column flex flex-wrap items-center justify-center pt-4 md:flex-row"
                aria-label="Table navigation"
            >
                {{ $clases->links() }}
            </nav>
        </div>
    </div>
</x-app-layout>
