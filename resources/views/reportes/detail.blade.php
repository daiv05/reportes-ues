@php
    $headersSubalternos = [
        ['text' => 'No.', 'align' => 'left'],
        ['text' => 'Empleado', 'align' => 'left'],
        ['text' => 'Puesto', 'align' => 'left'],
        ['text' => 'Correo electrónico', 'align' => 'left'],
    ];

    $headersSupervisor = [
        ['text' => 'Empleado', 'align' => 'left'],
        ['text' => 'Correo electrónico', 'align' => 'left'],
    ];

    $updateAvailable = false;
    if (
        (in_array($reporte->estado_ultimo_historial?->id, [1, 2, 3, 6]) && $reporte->relacion_usuario['empleado']) ||
        ($reporte->estado_ultimo_historial?->id === 4 && $reporte->relacion_usuario['supervisor'])
    ) {
        $updateAvailable = true;
    }
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="p-6 text-2xl font-bold text-red-900 dark:text-gray-100">
            {{ __('Detalle de reporte') }}
        </div>
    </x-slot>

    <div class="mt-12 mb-8">
        <div class="flex flex-col lg:flex-row w-full">
            <!-- Columna izquierda (70%) -->
            <div class="w-full lg:w-[60%] pl-8 pr-2">
                <div class="mb-4">
                    <!-- Fila 1 -->
                    <div
                        class="text-3xl font-bold md:ml-12 mb-8 flex justify-center md:justify-start text-center md:text-start">
                        <p>{{ $reporte->titulo }}</p>
                    </div>
                </div>
                <div class="mb-4">
                    <!-- Fila 2 -->
                    <div>
                        <div class="flex flex-row gap-6 font-semibold">
                            <x-heroicon-o-clipboard-document class="w-6 h-6" />
                            Descripción
                        </div>
                        <div class="md:ml-12 mt-2">
                            <x-text-area id="descripcion" rows="8" :disabled="true">
                                {{ $reporte->descripcion }}
                            </x-text-area>
                        </div>

                    </div>
                </div>
                @if ($reporte->aula)
                    <div class="mb-4">
                        <!-- Fila 3 -->
                        <div class="font-semibold">
                            <div class="flex flex-row gap-6">
                                <x-heroicon-o-map-pin class="w-6 h-6" />
                                Lugar
                            </div>
                            <div class="ml-12 mt-2">
                                <input type="text"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                    placeholder="Aula de ejemplo" value="{{ $reporte->aula?->nombre }}" disabled />
                            </div>
                        </div>
                    </div>
                @endif
                @if (isset($reporte->actividad))
                    <div class="mb-4">
                        <div class="font-semibold">
                            <div class="flex flex-row gap-6">
                                <x-heroicon-o-calendar-days class="w-6 h-6" />
                                Actividad reportada
                            </div>
                            <div class="ml-12 mt-2 overflow-auto">
                                <div>
                                    <table class="text-left text-sm text-gray-500 dark:text-gray-400 rtl:text-right">
                                        <thead
                                            class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">Asignaturas</th>
                                                <th scope="col" class="px-6 py-3">Aulas</th>
                                                <th scope="col" class="px-6 py-3">No. de grupo</th>
                                                <th scope="col" class="px-6 py-3">Escuela</th>
                                                <th scope="col" class="px-6 py-3">Horario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <x-table.tr>
                                                <x-table.td>{{ $reporte->actividad->asignaturas[0]->nombre }}</x-table.td>
                                                <x-table.td>{{ $reporte->actividad->aulas[0]->nombre }}</x-table.td>
                                                <x-table.td>{{ $reporte->actividad->clase->numero_grupo }}</x-table.td>
                                                <x-table.td>{{ $reporte->actividad->asignaturas[0]->escuela->nombre }}</x-table.td>
                                                <x-table.td>{{ $reporte->actividad->hora_inicio . ' - ' . $reporte->actividad->hora_fin }}</x-table.td>
                                            </x-table.tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <!-- Columna derecha (40%) -->
            <div class="w-full lg:w-[40%] flex sm:px-8 lg:pt-24 pt-16 pb-8 justify-center lg:justify-start text-start">
                <div class="flex flex-col ml-16 lg:ml-2 w-full text-sm">
                    <div class="flex flex-row mb-3">
                        <div class="basis-1/3">
                            <p class="text-gray-500 font-semibold">
                                Estado
                            </p>
                        </div>
                        <div class="basis-2/3">
                            <x-status.chips :text="$reporte->estado_ultimo_historial?->nombre ?? 'NO ASIGNADO'" class="mb-2" />
                        </div>
                    </div>
                    <div class="flex flex-row mb-4">
                        <div class="basis-1/3">
                            <p class="text-gray-500 font-semibold">
                                Fecha
                            </p>
                        </div>
                        <div class="basis-2/3">
                            <p class="text-black font-semibold">
                                {{ \Carbon\Carbon::parse($reporte->fecha_reporte)->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-row mb-4">
                        <div class="basis-1/3">
                            <p class="text-gray-500 font-semibold">
                                Hora
                            </p>
                        </div>
                        <div class="basis-2/3">
                            <p class="text-black font-semibold">
                                {{ \Carbon\Carbon::parse($reporte->hora_reporte)->format('h:i A') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-row mb-4">
                        <div class="basis-1/3">
                            <p class="text-gray-500 font-semibold">
                                Usuario
                            </p>
                        </div>
                        <div class="basis-2/3">
                            <p class="text-black font-semibold">
                                {{ $reporte->usuarioReporta?->persona?->nombre }}
                                {{ $reporte->usuarioReporta?->persona?->apellido }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-general.divider />

        <form method="POST" action="{{ route('reportes.realizarAsignacion', ['id' => $reporte->id]) }}"
            enctype="multipart/form-data">
            @csrf
            <x-reportes.detail.container>
                <x-reportes.detail.header title="Asignación">
                    @if (!$reporte->estado_ultimo_historial?->nombre && $reporte->no_procede == 0)
                        <div>
                            <button id="marcarNoProcede"
                                class="bg-red-700 text-white text-sm py-2 px-4 rounded hover:bg-red-500" x-data
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-modal')">
                                No Procede
                            </button>
                        </div>
                        @include('reportes.partials.modal-not-valid-report')
                    @endif
                </x-reportes.detail.header>
                <x-reportes.detail.block>
                    <x-reportes.detail.subheader subtitle="Entidad" icon="heroicon-o-briefcase" />
                    <x-reportes.detail.subheader-content>
                        @if (!$reporte->estado_ultimo_historial?->nombre && $reporte->no_procede == 0)
                            <select id="entidad"
                                class="border border-gray-300 text-gray-900 focus:border-red-500 focus:outline-none focus:ring-red-500 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                onchange="document.getElementById('id_entidad').value = this.value; location.href='?entidad=' + this.value;">
                                <option value="" disabled selected>Selecciona una entidad</option>
                                @foreach ($entidades as $entidad)
                                    <option value="{{ $entidad->id }}"
                                        {{ request()->get('entidad') == $entidad->id ? 'selected' : '' }}>
                                        {{ $entidad->nombre }}</option>
                                @endforeach
                            </select>
                            @include('components.forms.input-error', [
                                'messages' => $errors->get('id_entidad'),
                            ])
                            <input type="hidden" id="id_entidad" name="id_entidad"
                                value="{{ request()->get('entidad') }}">

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const urlParams = new URLSearchParams(window.location.search);
                                    const entidadId = urlParams.get('entidad');
                                    if (entidadId) {
                                        document.getElementById('entidad').value = entidadId;
                                    }
                                });
                            </script>
                        @else
                            <select id="entidad"
                                class="border border-gray-300 text-gray-900 focus:border-red-500 focus:outline-none focus:ring-red-500 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                disabled>
                                <option value="" disabled selected>Selecciona una entidad</option>
                                @foreach ($entidades as $entidad)
                                    <option value="{{ $entidad->id }}"
                                        {{ $reporte->accionesReporte->id_entidad_asignada == $entidad->id ? 'selected' : '' }}>
                                        {{ $entidad->nombre }}</option>
                                @endforeach
                            </select>
                        @endif
                    </x-reportes.detail.subheader-content>
                </x-reportes.detail.block>
                <x-reportes.detail.block>
                    <x-reportes.detail.subheader subtitle="Subalternos" icon="heroicon-o-shopping-bag" />
                    <x-reportes.detail.subheader-content>
                        @if (!$reporte->estado_ultimo_historial?->nombre && $reporte->no_procede == 0)
                            <x-picklist.picklist :items="$empleadosPorEntidad" :asignados="[]" :empleados="true"
                                tituloDisponibles="Empleados disponibles" tituloAsignados="Empleados asignados"
                                placeholderDisponibles="Buscar empleados..." placeholderAsignados="Buscar asignados..."
                                inputName="id_empleados_puestos" />
                            @include('components.forms.input-error', [
                                'messages' => $errors->get('id_empleados_puestos'),
                            ])
                        @else
                            <div class="mt-6 bg-white shadow overflow-auto sm:rounded-lg text-center">
                                <div class="border-gray-200">
                                    <x-table.base :headers="$headersSubalternos">
                                        @foreach ($reporte->empleadosAcciones as $index => $empleadoAccion)
                                            <x-table.tr>
                                                <x-table.td>{{ $index + 1 }}</x-table.td>
                                                <x-table.td>{{ $empleadoAccion->empleadoPuesto->usuario->persona->nombre . ' ' . $empleadoAccion->empleadoPuesto->usuario->persona->apellido }}</x-table.td>
                                                <x-table.td>{{ $empleadoAccion->empleadoPuesto->puesto->nombre }}</x-table.td>
                                                <x-table.td>{{ $empleadoAccion->empleadoPuesto->usuario->email }}</x-table.td>

                                            </x-table.tr>
                                        @endforeach
                                    </x-table.base>
                                </div>
                            </div>
                        @endif
                    </x-reportes.detail.subheader-content>
                </x-reportes.detail.block>
                <x-reportes.detail.block>
                    <x-reportes.detail.subheader subtitle="Supervisor" icon="heroicon-o-check-badge" />
                    <x-reportes.detail.subheader-content>
                        @if (!$reporte->estado_ultimo_historial?->nombre && $reporte->no_procede == 0)
                            <select id="supervisor" name="id_empleado_supervisor"
                                class="border border-gray-300 text-gray-900 focus:border-red-500 focus:outline-none focus:ring-red-500 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                                <option value="" disabled selected>Selecciona un supervisor</option>
                                @foreach ($supervisores as $supervisor)
                                    <option value="{{ $supervisor->id_empleado_puesto }}">
                                        {{ $supervisor->nombre_empleado }}
                                        {{ $supervisor->apellido_empleado }}
                                        - {{ $supervisor->email }}
                                    </option>
                                @endforeach
                            </select>
                            @include('components.forms.input-error', [
                                'messages' => $errors->get('id_empleado_supervisor'),
                            ])
                        @else
                            <div class="overflow-auto">
                                <div class="border-gray-200">
                                    <x-table.base :headers="$headersSupervisor">
                                        <x-table.tr>
                                            <x-table.td>{{ $reporte->accionesReporte->usuarioSupervisor->persona->nombre . ' ' . $reporte->accionesReporte->usuarioSupervisor->persona->apellido }}</x-table.td>
                                            <x-table.td>{{ $reporte->accionesReporte->usuarioSupervisor->email }}</x-table.td>
                                        </x-table.tr>
                                    </x-table.base>
                                </div>
                            </div>
                        @endif
                    </x-reportes.detail.subheader-content>
                </x-reportes.detail.block>
                <x-reportes.detail.block>
                    <x-reportes.detail.subheader subtitle="Comentario de administración"
                        icon="heroicon-o-chat-bubble-bottom-center-text" />
                    <x-reportes.detail.subheader-content>
                        @if (!$reporte->estado_ultimo_historial?->nombre && $reporte->no_procede == 0)
                            <textarea id="comentario" name="comentario" rows="8"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"></textarea>
                            @include('components.forms.input-error', [
                                'messages' => $errors->get('comentario'),
                            ])
                        @else
                            <textarea id="comentario" name="comentario" rows="8"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                disabled>{{ $reporte->accionesReporte->comentario }}</textarea>
                        @endif
                    </x-reportes.detail.subheader-content>
                </x-reportes.detail.block>
            </x-reportes.detail.container>

            @if (!$reporte->estado_ultimo_historial?->nombre && $reporte->no_procede == 0)
                <div class="flex flex-col lg:flex-row w-full justify-center mt-8">
                    <button id="enviarAsignacion"
                        class="bg-escarlata-ues text-white text-sm py-2 px-4 rounded hover:bg-red-700">
                        Enviar Asignación
                    </button>
                </div>
            @endif
        </form>

        @if ($reporte->accionesReporte)

            <x-general.divider />

            <x-reportes.detail.container>
                <x-reportes.detail.header title="Seguimiento">
                    {{-- Boton actualizar estado --}}
                    @if ($updateAvailable)
                        <div>
                            <button id="abrirActualizarSeguimiento"
                                class="bg-escarlata-ues text-white text-sm py-2 mb-4 px-4 rounded hover:bg-red-500 flex items-center"
                                x-data x-on:click="$dispatch('open-modal', 'actualizar-seguimiento-modal')">
                                <p class="mr-2">Actualizar</p>
                                <x-heroicon-o-bell-alert class="h-6 w-6" />
                            </button>
                        </div>
                    @endif
                    {{-- Modal actualizar seguimiento --}}
                    @include('reportes.partials.modal-update-assignment')
                </x-reportes.detail.header>
                <x-reportes.detail.block>
                    <x-reportes.detail.subheader-content>
                        <div class="flex justify-center md:justify-start">
                            @include('reportes.partials.timeline')
                        </div>
                    </x-reportes.detail.subheader-content>
                </x-reportes.detail.block>
            </x-reportes.detail.container>
        @endif
    </div>
</x-app-layout>
