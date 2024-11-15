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
                            <x-heroicon-o-clipboard-document class="w-6 h-6" />
                            Descripción
                        </div>
                        <div class="ml-12 mt-2">
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
                            <div class="ml-12 mt-2">
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
                @endif
            </div>

            <!-- Columna derecha (30%) -->
            <div class="w-full lg:w-[30%]">
                <div class="grid grid-cols-1 lg:grid-cols-2 grid-rows-8 lg:grid-rows-4 p-4">
                    <div>
                        <p class="text-gray-500 font-semibold">
                            Estado
                        </p>
                    </div>
                    <div>
                        <x-status.chips :text="$reporte->estado_ultimo_historial?->nombre ?? 'NO ASIGNADO'" class="mb-2" />
                    </div>
                    <div>
                        <p class="text-gray-500 font-semibold">
                            Fecha
                        </p>
                    </div>
                    <div>
                        <p class="text-black font-semibold">
                            {{ \Carbon\Carbon::parse($reporte->fecha_reporte)->format('d/m/Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 font-semibold">
                            Hora
                        </p>
                    </div>
                    <div>
                        <p class="text-black font-semibold">
                            {{ \Carbon\Carbon::parse($reporte->hora_reporte)->format('h:i A') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500 font-semibold">
                            Reportado <br /> por
                        </p>
                    </div>
                    <div>
                        <p class="text-black font-semibold">
                            {{ $reporte->usuarioReporta?->persona?->nombre }}
                            {{ $reporte->usuarioReporta?->persona?->apellido }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <x-general.divider />

        <form method="POST" action="{{ route('reportes.realizarAsignacion', ['id' => $reporte->id]) }}"
            enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col lg:flex-row w-full mt-4">
                <!-- Columna izquierda (70%) -->
                <div class="w-full lg:w-[70%] px-8">
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
                                <x-heroicon-o-briefcase class="w-6 h-6" />
                                Entidad
                            </div>
                            <div class="ml-12 mt-2">
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
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <!-- Fila 3 -->
                        <div class="font-semibold">
                            <div class="flex flex-row gap-6">
                                <x-heroicon-o-shopping-bag class="w-6 h-6" />
                                Subalternos
                            </div>
                            <div class="ml-12 mt-2">
                                @if (!$reporte->estado_ultimo_historial?->nombre && $reporte->no_procede == 0)
                                    <x-picklist.picklist :items="$empleadosPorEntidad" :asignados="[]" :empleados="true"
                                        tituloDisponibles="Empleados disponibles"
                                        tituloAsignados="Empleados asignados"
                                        placeholderDisponibles="Buscar empleados..."
                                        placeholderAsignados="Buscar asignados..." inputName="id_empleados_puestos" />
                                    @include('components.forms.input-error', [
                                        'messages' => $errors->get('id_empleados_puestos'),
                                    ])
                                @else
                                    <div>
                                        <ul>
                                            @foreach ($reporte->empleadosAcciones as $index => $empleadoAccion)
                                                <li class="mb-2">
                                                    <p class="text-gray-900 dark:text-white">
                                                        {{ $index + 1 }}
                                                        .
                                                        {{ $empleadoAccion->empleadoPuesto->usuario->persona->nombre }}
                                                        {{ $empleadoAccion->empleadoPuesto->usuario->persona->apellido }}
                                                    </p>
                                                    <p class="text-gray-600 dark:text-gray-400">
                                                        {{ $empleadoAccion->empleadoPuesto->puesto->nombre }}
                                                    </p>
                                                    <p class="text-gray-600 dark:text-gray-400">
                                                        {{ $empleadoAccion->empleadoPuesto->usuario->email }}
                                                    </p>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="mb-4">
                        <!-- Fila 3 -->
                        <div class="font-semibold">
                            <div class="flex flex-row gap-6">
                                <x-heroicon-o-check-badge class="w-6 h-6" />
                                Supervisor
                            </div>
                            <div class="ml-12 mt-2">
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
                                    <div>
                                        <div class="mb-2">
                                            <p class="text-gray-900 dark:text-white">
                                                {{ $reporte->accionesReporte->usuarioSupervisor->persona->nombre }}
                                                {{ $reporte->accionesReporte->usuarioSupervisor->persona->apellido }}
                                            </p>
                                            <p class="text-gray-600 dark:text-gray-400">
                                                {{ $reporte->accionesReporte->usuarioSupervisor->email }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="mb-4">
                        <!-- Fila 2 -->
                        <div class="font-semibold">
                            <div class="flex flex-row gap-6">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                </svg>
                                Comentario de administración
                            </div>
                            <div class="ml-12 mt-2">
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
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Columna derecha (30%) -->
                <div class="w-full lg:w-[30%] px-8 flex justify-center">
                    @if (!$reporte->estado_ultimo_historial?->nombre && $reporte->no_procede == 0)
                        <div>
                            <button id="marcarNoProcede"
                                class="bg-red-700 text-white text-sm py-2 px-4 rounded hover:bg-red-500" x-data
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-modal')">
                                Marcar como No procede
                            </button>
                        </div>
                        {{-- Modal de No procede --}}
                        @include('reportes.partials.modal-not-valid-report')
                    @endif
                </div>
            </div>
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
            <div class="flex flex-col lg:flex-row w-full">
                <!-- Columna izquierda -->
                <div class="w-full lg:w-[80%] px-8">
                    {{--  Timeline --}}
                    <div class="mt-4"></div>
                    <div class="mb-4">
                        <div class="text-xl font-bold ml-12 mb-8">
                            <p>Seguimiento</p>
                        </div>
                    </div>
                    @include('reportes.partials.timeline')
                </div>
                <!-- Columna derecha -->
                <div class="w-full lg:w-[20%] px-8">
                    {{-- Boton actualizar estado --}}
                    @if (
                        (in_array($reporte->estado_ultimo_historial?->id, [1, 2, 3, 6]) && $reporte->relacion_usuario['empleado']) ||
                            ($reporte->estado_ultimo_historial?->id === 4 && $reporte->relacion_usuario['supervisor']))
                        <button id="abrirActualizarSeguimiento"
                            class="bg-escarlata-ues text-white text-sm py-2 px-4 rounded hover:bg-red-500 flex items-center"
                            x-data x-on:click="$dispatch('open-modal', 'actualizar-seguimiento-modal')">
                            <p class="mr-2">Actualizar</p>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5" />
                            </svg>
                        </button>
                    @endif
                    {{-- Modal actualizar seguimiento --}}
                    @include('reportes.partials.modal-update-assignment')
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
