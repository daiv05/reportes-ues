@php
    $headers = [
        ['text' => 'Asignatura', 'align' => 'left'],
        ['text' => 'Aula', 'align' => 'left'],
        ['text' => 'Modalidad', 'align' => 'left'],
        ['text' => 'No. de grupo', 'align' => 'center'],
        ['text' => 'Tipo', 'align' => 'left'],
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

    <x-container>
        {{-- FILTROS --}}
        <div class="flex-column flex flex-wrap items-center gap-3 space-y-4 pb-4 sm:flex-row sm:space-y-0">
            <div class="flex-col flex flex-wrap items-center justify-between space-y-4 pb-4 sm:flex-row sm:space-y-0 w-full">
                <form action="{{ route('listado-clases') }}" method="GET" class="flex-row flex flex-wrap items-center space-x-8 mt-4 w-full">
                    <div class="flex w-full flex-col md:w-5/6">
                        <x-forms.row :columns="2">
                            <x-forms.field
                                id="materia"
                                label="Materia"
                                name="materia"
                                :value="request('materia')"
                            />
                            <x-forms.select
                                name="escuela"
                                label="Escuela"
                                :options="$escuelas"
                                selected="{{ request('escuela') }}"
                            />
                        </x-forms.row>
                        <x-forms.row :columns="3">
                            <x-forms.field
                                id="aula"
                                label="Aula"
                                name="aula"
                                :value="request('aula')"
                            />

                            <x-forms.select
                                name="tipo"
                                label="Tipo de clase"
                                :options="$tiposClase"
                                selected="{{ request('tipo') }}"
                            />

                            <x-forms.select
                                name="modalidad"
                                label="Modalidad"
                                :options="$modalidades"
                                selected="{{ request('modalidad') }}"
                            />
                        </x-forms.row>
                    </div>
                    <div class="flex flex-wrap space-x-4">
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
                    </div>
                </form>
            </div>
            {{-- TABLA --}}
            <div class="mx-auto mb-6 flex flex-col items-center justify-center overflow-x-auto sm:rounded-lg">
                <x-table.base :headers="$headers" id="table-content">
                    @if($clases->isEmpty())
                        <x-table.td colspan="{{ count($headers) }}" justify="center">
                            <span class="text-gray-500">No se encontraron registros</span>
                        </x-table.td>
                    @endif
                    @foreach ($clases as $clase)
                        <x-table.tr>
                            <x-table.td justify="center">{{ $clase->actividad->asignaturas[0]->nombre }}</x-table.td>
                            <x-table.td justify="center">{{ $clase->actividad->aulas[0]->nombre }}</x-table.td>
                            <x-table.td justify="center">{{ $clase->actividad->modalidad->nombre }}</x-table.td>
                            <x-table.td justify="center">{{ $clase->numero_grupo }}</x-table.td>
                            <x-table.td>{{ $clase->tipoClase->nombre }}</x-table.td>
                            <x-table.td>{{ $clase->actividad->asignaturas[0]->escuela->nombre }}</x-table.td>
                            <x-table.td>{{ $clase->actividad->hora_inicio. ' - '. $clase->actividad->hora_fin }}</x-table.td>
                            <x-table.td>
                                <a href="{{ route('crear-reporte', ['actividad' => $clase->id]) }}" class="font-medium text-gray-700 hover:underline">
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
    </x-container>
</x-app-layout>
