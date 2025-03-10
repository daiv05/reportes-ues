@php
    $headersSubalternos = [
        ['text' => 'No.', 'align' => 'left'],
        ['text' => 'Empleado', 'align' => 'left'],
        ['text' => 'Puesto', 'align' => 'left'],
        ['text' => 'Correo electrónico', 'align' => 'left'],
    ];

    $headersSupervisor = [['text' => 'Empleado', 'align' => 'left'], ['text' => 'Correo electrónico', 'align' => 'left']];

    $updateAvailable = false;
    if (
        (in_array($reporte->estado_ultimo_historial?->id, [1, 2, 3, 6]) && $reporte->relacion_usuario['empleado']) ||
        ($reporte->estado_ultimo_historial?->id === 4 && $reporte->relacion_usuario['supervisor'])
    ) {
        $updateAvailable = true;
    }

    $nombreEstadoActual = $reporte->estado_ultimo_historial?->nombre ?? null;
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="p-6 text-2xl font-bold text-red-900 dark:text-gray-100">
            {{ __('Detalle de reporte') }}
        </div>
    </x-slot>

    <div class="mb-8 mt-12">
        @if ($nombreEstadoActual === 'FINALIZADO')
            <div class="flex justify-center">
                @canany(['REPORTES_REVISION_SOLUCION', 'REPORTES_ASIGNAR'])
                    <a
                        href="{{ route('reportes.verInforme', ['id' => $reporte->id]) }}"
                        class="cursor-pointer rounded bg-green-500 px-10 py-2 text-sm text-white hover:bg-green-700"
                    >
                        Ver informe del reporte
                    </a>
                @endcanany
            </div>
        @endif

        <div class="flex w-full flex-col lg:flex-row">
            <!-- Columna izquierda (70%) -->
            <div class="w-full pl-8 pr-2 lg:w-[60%]">
                <div class="mb-4">
                    <!-- Fila 1 -->
                    <div
                        class="mb-8 flex justify-center text-center text-3xl font-bold md:ml-12 md:justify-start md:text-start"
                    >
                        <p>{{ $reporte->titulo }}</p>
                    </div>
                </div>
                <div class="mb-4">
                    <!-- Fila 2 -->
                    <div>
                        <div class="flex flex-row gap-6 font-semibold">
                            <x-heroicon-o-clipboard-document class="h-6 w-6" />
                            Descripción
                        </div>
                        <div class="mt-2 md:ml-12">
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
                                <x-heroicon-o-map-pin class="h-6 w-6" />
                                Lugar
                            </div>
                            <div class="ml-12 mt-2">
                                <input
                                    type="text"
                                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                    placeholder="Aula de ejemplo"
                                    value="{{ $reporte->aula?->nombre }}"
                                    disabled
                                />
                            </div>
                        </div>
                    </div>
                @endif

                @if (isset($reporte->actividad))
                    <div class="mb-4">
                        <div class="font-semibold">
                            <div class="flex flex-row gap-6">
                                <x-heroicon-o-calendar-days class="h-6 w-6" />
                                Actividad reportada
                            </div>
                            <div class="ml-12 mt-2 overflow-x-auto">
                                <div>
                                    <table class="text-left text-sm text-gray-500 dark:text-gray-400 rtl:text-right">
                                        <thead
                                            class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400"
                                        >
                                            <tr>
                                                @if ($reporte->actividad->clase)
                                                    <th scope="col" class="px-6 py-3">Asignaturas</th>
                                                    <th scope="col" class="px-6 py-3">Aulas</th>
                                                    <th scope="col" class="px-6 py-3">Tipo</th>
                                                    <th scope="col" class="px-6 py-3">No. de grupo</th>
                                                    <th scope="col" class="px-6 py-3">Escuela</th>
                                                    <th scope="col" class="px-6 py-3">Horario</th>
                                                @else
                                                    <th scope="col" class="px-6 py-3">Actividad</th>
                                                    <th scope="col" class="px-6 py-3">Aulas</th>
                                                    <th scope="col" class="px-6 py-3">Modalidad</th>
                                                    <th scope="col" class="px-6 py-3">Fecha</th>
                                                    <th scope="col" class="px-6 py-3">Horario</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <x-table.tr>
                                                @if ($reporte->actividad->clase)
                                                    <x-table.td>
                                                        {{ $reporte->actividad->asignaturas[0]->nombre }}
                                                    </x-table.td>
                                                    <x-table.td>
                                                        @php
                                                            $aulasClase = '';
                                                            foreach ($reporte->actividad->aulas as $aula) {
                                                                $aulasClase .= $aula->nombre . ', ';
                                                            }
                                                            echo rtrim($aulasClase, ', ');
                                                        @endphp
                                                    </x-table.td>
                                                    <x-table.td>
                                                        {{ $reporte->actividad->clase->tipoClase->nombre }}
                                                    </x-table.td>
                                                    <x-table.td>
                                                        {{ $reporte->actividad->clase->numero_grupo }}
                                                    </x-table.td>
                                                    <x-table.td>
                                                        {{ $reporte->actividad->asignaturas[0]->escuela->nombre }}
                                                    </x-table.td>
                                                    <x-table.td>
                                                        {{
                                                            Carbon\Carbon::parse($reporte->actividad->hora_inicio)->format('h:i A') .
                                                                ' - ' .
                                                                Carbon\Carbon::parse($reporte->actividad->hora_fin)->format('h:i A')
                                                        }}
                                                    </x-table.td>
                                                @else
                                                    <x-table.td>
                                                        {{ $reporte->actividad->evento->descripcion }}
                                                    </x-table.td>
                                                    <x-table.td>
                                                        @php
                                                            $aulasEvento = '';
                                                            foreach ($reporte->actividad->aulas as $aula) {
                                                                $aulasEvento .= $aula->nombre . ', ';
                                                            }
                                                            echo rtrim($aulasEvento, ', ');
                                                        @endphp
                                                    </x-table.td>
                                                    <x-table.td>
                                                        {{ $reporte->actividad->modalidad->nombre }}
                                                    </x-table.td>
                                                    <x-table.td>
                                                        {{ Carbon\Carbon::parse($reporte->actividad->fecha)->format('d/m/Y') }}
                                                    </x-table.td>
                                                    <x-table.td>
                                                        {{
                                                            Carbon\Carbon::parse($reporte->actividad->hora_inicio)->format('h:i A') .
                                                                ' - ' .
                                                                Carbon\Carbon::parse($reporte->actividad->hora_fin)->format('h:i A')
                                                        }}
                                                    </x-table.td>
                                                @endif
                                            </x-table.tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Evidencia -->
                @if (count($reporte->reporteEvidencias) > 0)
                    <div class="mb-4">
                        <!-- Fila 3 -->
                        <div class="font-semibold">
                            <div class="flex flex-row gap-6">
                                <x-heroicon-o-camera class="h-6 w-6" />
                                Evidencia
                            </div>
                            <div class="ml-12 mt-2">
                                <button
                                    id="button"
                                    type="button"
                                    class="w-full rounded-lg bg-red-800 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-red-900 focus:outline-none focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 sm:w-auto"
                                >
                                    Ver
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <!-- Columna derecha (40%) -->
            <div class="flex w-full justify-center pb-8 pt-16 text-start sm:px-8 lg:w-[40%] lg:justify-start lg:pt-24">
                <div class="ml-16 flex w-full flex-col text-sm lg:ml-2">
                    <div class="mb-3 flex flex-row">
                        <div class="basis-1/3">
                            <p class="font-semibold text-gray-500">Estado</p>
                        </div>
                        <div class="basis-2/3">
                            @if ($reporte->no_procede === 0)
                                <x-status.chips :text="$nombreEstadoActual ?? 'NO ASIGNADO'" class="mb-2" />
                            @else
                                <x-status.chips text="NO PROCEDE" class="mb-2" />
                            @endif
                        </div>
                    </div>
                    <div class="mb-4 flex flex-row">
                        <div class="basis-1/3">
                            <p class="font-semibold text-gray-500">Fecha</p>
                        </div>
                        <div class="basis-2/3">
                            <p class="font-semibold text-black">
                                {{ \Carbon\Carbon::parse($reporte->fecha_reporte)->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="mb-4 flex flex-row">
                        <div class="basis-1/3">
                            <p class="font-semibold text-gray-500">Hora</p>
                        </div>
                        <div class="basis-2/3">
                            <p class="font-semibold text-black">
                                {{ \Carbon\Carbon::parse($reporte->hora_reporte)->format('h:i A') }}
                            </p>
                        </div>
                    </div>
                    {{-- Solo si no es estudiante --}}
                    @if (! Auth::user()->es_estudiante)
                        <div class="mb-4 flex flex-row">
                            <div class="basis-1/3">
                                <p class="font-semibold text-gray-500">Usuario</p>
                            </div>
                            <div class="basis-2/3">
                                <p class="font-semibold text-black">
                                    {{ $reporte->usuarioReporta?->persona?->nombre }}
                                    {{ $reporte->usuarioReporta?->persona?->apellido }}
                                </p>
                            </div>
                        </div>
                    @endif

                    <div class="mb-4 flex flex-row">
                        <div class="basis-1/3">
                            <p class="font-semibold text-gray-500">Categoría</p>
                        </div>
                        <div class="basis-2/3">
                            <p class="font-semibold text-black">
                                {{ $reporte?->accionesReporte?->categoriaReporte?->nombre ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-general.divider />

        @canany(['REPORTES_ACTUALIZAR_ESTADO', 'REPORTES_REVISION_SOLUCION'])
            @if (

                ($reporte->no_procede === 0 &&
                    auth()
                        ->user()
                        ->can('REPORTES_ASIGNAR') &&
                    ! $nombreEstadoActual) ||
                ($reporte->no_procede === 0 && $nombreEstadoActual)            )
                <x-reportes.detail.container>
                    <x-reportes.detail.header title="Asignación" :required="!$nombreEstadoActual">
                        @if (! $nombreEstadoActual)
                            <div>
                                @canany(['REPORTES_ASIGNAR'])
                                    <button
                                        id="marcarNoProcede"
                                        class="rounded bg-red-700 px-4 py-2 text-sm text-white hover:bg-red-500"
                                        x-data
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-modal')"
                                    >
                                        No Procede
                                    </button>
                                @endcanany
                            </div>
                            @include('reportes.partials.modal-not-valid-report')
                        @endif
                    </x-reportes.detail.header>
                </x-reportes.detail.container>
                <form
                    method="POST"
                    action="{{ route('reportes.realizarAsignacion', ['id' => $reporte->id]) }}"
                    enctype="multipart/form-data"
                >
                    @csrf
                    <x-reportes.detail.container>
                        <x-reportes.detail.block>
                            <x-reportes.detail.subheader
                                subtitle="Entidad"
                                icon="heroicon-o-briefcase"
                                :required="!$nombreEstadoActual"
                            />
                            <x-reportes.detail.subheader-content>
                                @if (! $nombreEstadoActual)
                                    <select
                                        id="entidad"
                                        class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-red-500 focus:outline-none focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                        onchange="document.getElementById('id_entidad').value = this.value; location.href='?entidad=' + this.value;"
                                    >
                                        <option value="" disabled selected>Selecciona una entidad</option>
                                        @foreach ($entidades as $entidad)
                                            <option
                                                value="{{ $entidad->id }}"
                                                {{ request()->get('entidad') == $entidad->id ? 'selected' : '' }}
                                            >
                                                {{ $entidad->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @include(
                                        'components.forms.input-error',
                                        [
                                            'messages' => $errors->get('id_entidad'),
                                        ]
                                    )
                                    <input
                                        type="hidden"
                                        id="id_entidad"
                                        name="id_entidad"
                                        value="{{ request()->get('entidad') }}"
                                    />

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            const urlParams = new URLSearchParams(window.location.search);
                                            const entidadId = urlParams.get('entidad');
                                            if (entidadId) {
                                                document.getElementById('entidad').value = entidadId;
                                            }
                                        });
                                    </script>
                                @else
                                    <select
                                        id="entidad"
                                        class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-red-500 focus:outline-none focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                        disabled
                                    >
                                        <option value="" disabled selected>Selecciona una entidad</option>
                                        @foreach ($entidades as $entidad)
                                            <option
                                                value="{{ $entidad->id }}"
                                                {{ $reporte->accionesReporte->id_entidad_asignada == $entidad->id ? 'selected' : '' }}
                                            >
                                                {{ $entidad->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </x-reportes.detail.subheader-content>
                        </x-reportes.detail.block>
                        <x-reportes.detail.block>
                            <x-reportes.detail.subheader
                                subtitle="Subalternos"
                                icon="heroicon-o-shopping-bag"
                                :required="!$nombreEstadoActual"
                            />
                            <x-reportes.detail.subheader-content>
                                @if (! $nombreEstadoActual)
                                    <x-picklist.picklist
                                        :items="$empleadosPorEntidad"
                                        :asignados="[]"
                                        :empleados="true"
                                        tituloDisponibles="Empleados disponibles"
                                        tituloAsignados="Empleados asignados"
                                        placeholderDisponibles="Buscar empleados..."
                                        placeholderAsignados="Buscar asignados..."
                                        inputName="id_empleados_puestos"
                                    />
                                    @include(
                                        'components.forms.input-error',
                                        [
                                            'messages' => $errors->get('id_empleados_puestos'),
                                        ]
                                    )
                                @else
                                    <div class="mt-6 overflow-x-auto bg-white text-center shadow sm:rounded-lg">
                                        <div class="border-gray-200">
                                            <x-table.base :headers="$headersSubalternos">
                                                @foreach ($reporte->empleadosAcciones as $index => $empleadoAccion)
                                                    <x-table.tr>
                                                        <x-table.td>{{ $index + 1 }}</x-table.td>
                                                        <x-table.td>
                                                            {{ $empleadoAccion->empleadoPuesto->usuario->persona->nombre . ' ' . $empleadoAccion->empleadoPuesto->usuario->persona->apellido }}
                                                        </x-table.td>
                                                        <x-table.td>
                                                            {{ $empleadoAccion->empleadoPuesto->puesto->nombre }}
                                                        </x-table.td>
                                                        <x-table.td>
                                                            {{ $empleadoAccion->empleadoPuesto->usuario->email }}
                                                        </x-table.td>
                                                    </x-table.tr>
                                                @endforeach
                                            </x-table.base>
                                        </div>
                                    </div>
                                @endif
                            </x-reportes.detail.subheader-content>
                        </x-reportes.detail.block>
                        <x-reportes.detail.block>
                            <x-reportes.detail.subheader
                                subtitle="Supervisor"
                                icon="heroicon-o-check-badge"
                                :required="!$nombreEstadoActual"
                            />
                            <x-reportes.detail.subheader-content>
                                @if (! $nombreEstadoActual)
                                    <select
                                        id="supervisor"
                                        name="id_empleado_supervisor"
                                        class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-red-500 focus:outline-none focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                    >
                                        <option value="" disabled selected>Selecciona un supervisor</option>
                                        @foreach ($supervisores as $supervisor)
                                            <option value="{{ $supervisor->id_empleado_puesto }}">
                                                {{ $supervisor->nombre_empleado }}
                                                {{ $supervisor->apellido_empleado }}
                                                - {{ $supervisor->email }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @include(
                                        'components.forms.input-error',
                                        [
                                            'messages' => $errors->get('id_empleado_supervisor'),
                                        ]
                                    )
                                @else
                                    <div class="overflow-x-auto">
                                        <div class="border-gray-200">
                                            <x-table.base :headers="$headersSupervisor">
                                                <x-table.tr>
                                                    <x-table.td>
                                                        {{ $reporte->accionesReporte->usuarioSupervisor->persona->nombre . ' ' . $reporte->accionesReporte->usuarioSupervisor->persona->apellido }}
                                                    </x-table.td>
                                                    <x-table.td>
                                                        {{ $reporte->accionesReporte->usuarioSupervisor->email }}
                                                    </x-table.td>
                                                </x-table.tr>
                                            </x-table.base>
                                        </div>
                                    </div>
                                @endif
                            </x-reportes.detail.subheader-content>
                        </x-reportes.detail.block>
                        <x-reportes.detail.block>
                            <x-reportes.detail.subheader subtitle="Bienes" icon="heroicon-o-clipboard-document-list" />
                            <x-reportes.detail.subheader-content>
                                @if (! $nombreEstadoActual)
                                    <div class="pb-4">
                                        <span class="text-gray-600">
                                            Si el reporte involucra la reparación/mantenimiento de un bien de la
                                            facultad, especificarlo aqui
                                        </span>
                                    </div>
                                    @include('reportes.partials.assets-specification')
                                @else
                                    @if ($reporte->reporteBienes->isEmpty())
                                        <div class="text-start text-gray-500">
                                            <span>N/A</span>
                                        </div>
                                    @else
                                        <div class="mt-4 overflow-x-auto">
                                            {{-- TABLA --}}
                                            @php
                                                $headersBienesDetalle = [
                                                    ['text' => 'Código', 'align' => 'left'],
                                                    ['text' => 'Nombre', 'align' => 'left'],
                                                    ['text' => 'Descripción', 'align' => 'left'],
                                                ];
                                            @endphp

                                            <x-table.base :headers="$headersBienesDetalle">
                                                @foreach ($reporte->reporteBienes as $reporteBien)
                                                    <x-table.tr>
                                                        <x-table.td>{{ $reporteBien->bien->codigo }}</x-table.td>
                                                        <x-table.td>{{ $reporteBien->bien->nombre }}</x-table.td>
                                                        <x-table.td>
                                                            {{ $reporteBien->bien->descripcion }}
                                                        </x-table.td>
                                                    </x-table.tr>
                                                @endforeach
                                            </x-table.base>
                                        </div>
                                    @endif
                                @endif
                            </x-reportes.detail.subheader-content>
                        </x-reportes.detail.block>
                        <x-reportes.detail.block>
                            <x-reportes.detail.subheader
                                subtitle="Comentario de administración"
                                icon="heroicon-o-chat-bubble-bottom-center-text"
                            />
                            <x-reportes.detail.subheader-content>
                                @if (! $nombreEstadoActual)
                                    <textarea
                                        id="comentario"
                                        name="comentario"
                                        rows="8"
                                        maxlength="255"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                    ></textarea>
                                    @include(
                                        'components.forms.input-error',
                                        [
                                            'messages' => $errors->get('comentario'),
                                        ]
                                    )
                                @else
                                    <textarea
                                        id="comentario"
                                        name="comentario"
                                        rows="8"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm"
                                        disabled
                                    >{{ $reporte->accionesReporte->comentario }}</textarea>
                                @endif
                            </x-reportes.detail.subheader-content>
                        </x-reportes.detail.block>
                        <x-reportes.detail.block>
                            <x-reportes.detail.subheader
                                subtitle="Asignar categoria"
                                icon="heroicon-o-tag"
                                :required="!$nombreEstadoActual"
                            />
                            <x-reportes.detail.subheader-content>
                                @if (! $nombreEstadoActual)
                                    <div class="pb-4">
                                        <span class="text-gray-600">
                                            Asigna una categoría al reporte basado en el tiempo máximo de resolución que
                                            se espera
                                        </span>
                                    </div>
                                    <select
                                        id="id_categoria_reporte"
                                        onchange="actualizarDescripcionCategoria(this.value)"
                                        name="id_categoria_reporte"
                                        class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-red-500 focus:outline-none focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                    >
                                        <option value="" disabled selected>Seleccionar categoria</option>
                                        @foreach ($categoriasReporte as $categoria)
                                            <option
                                                value="{{ $categoria->id }}"
                                                {{ request()->get('id_categoria_reporte') == $categoria->id ? 'selected' : '' }}
                                            >
                                                {{ $categoria->nombre . ' - (' . $categoria->tiempo_promedio . ' ' . $categoria->unidad_tiempo . ')' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @include(
                                        'components.forms.input-error',
                                        [
                                            'messages' => $errors->get('id_categoria_reporte'),
                                        ]
                                    )
                                    <div class="pb-4">
                                        <span id="dsp-ctg" class="text-sm text-gray-600"></span>
                                    </div>
                                @else
                                    <select
                                        id="entidad"
                                        class="block w-full rounded-lg border border-gray-300 p-2.5 text-sm text-gray-900 focus:border-red-500 focus:outline-none focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                        disabled
                                    >
                                        <option value="" disabled>Selecciona una entidad</option>
                                        @foreach ($categoriasReporte as $categoria)
                                            <option
                                                value="{{ $categoria->id }}"
                                                {{ $reporte->accionesReporte->id_categoria_reporte == $categoria->id ? 'selected' : '' }}
                                            >
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif

                                <script>
                                    function actualizarDescripcionCategoria(idCategoria) {
                                        const categoria = @json($categoriasReporte);
                                        const categoriaSeleccionada = categoria.find((cat) => cat.id == idCategoria);
                                        document.getElementById('dsp-ctg').innerText =
                                            `Descripción: ${categoriaSeleccionada.descripcion}`;
                                    }
                                </script>
                            </x-reportes.detail.subheader-content>
                        </x-reportes.detail.block>
                    </x-reportes.detail.container>

                    @if (! $nombreEstadoActual)
                        <div class="mt-8 flex w-full flex-col justify-center lg:flex-row">
                            @canany(['REPORTES_ASIGNAR'])
                                <button
                                    id="enviarAsignacion"
                                    class="rounded bg-escarlata-ues px-4 py-2 text-sm text-white hover:bg-red-700"
                                >
                                    Enviar Asignación
                                </button>
                            @endcanany
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
                                    @canany(['REPORTES_ACTUALIZAR_ESTADO'])
                                        <button
                                            id="abrirActualizarSeguimiento"
                                            class="mb-4 flex items-center rounded bg-escarlata-ues px-4 py-2 text-sm text-white hover:bg-red-500"
                                            x-data
                                            x-on:click="$dispatch('open-modal', 'actualizar-seguimiento-modal')"
                                        >
                                            <p class="mr-2">Actualizar</p>
                                            <x-heroicon-o-bell-alert class="h-6 w-6" />
                                        </button>
                                    @endcanany
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
            @endif
        @endcanany
    </div>
</x-app-layout>
