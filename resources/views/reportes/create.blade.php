<x-app-layout>
    <x-slot name="header">
        <div class="p-6 text-2xl font-bold text-red-900 dark:text-gray-100">
            {{ __('Realizar reporte sobre actividad') }}
        </div>
    </x-slot>

    <div>
        <div>
            <div class="p-6 text-center text-gray-500 dark:text-gray-100">
                {{ 'Fecha y hora actual: ' . \Carbon\Carbon::now()->format('d/m/Y h:i A') }}
            </div>

            <div class="my-8">
                <form id="reporteForm" class="md:mx-16" method="POST" action="{{ route('reportes.store') }}">
                    @csrf
                    <!-- Titulo -->
                    <div class="mb-5">
                        <label for="titulo" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Titulo del reporte
                        </label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5">
                                <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                     viewBox="0 0 14 9" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.833313 1.6V1H1.49998V1.6H0.833313ZM0.833313 4.8V4.2H1.49998V4.8H0.833313ZM0.833313 8V7.4H1.49998V8H0.833313ZM12.8333 1.6H4.49998C4.40514 1.6 4.31808 1.56364 4.25699 1.50499C4.19659 1.44701 4.16665 1.37283 4.16665 1.3C4.16665 1.22717 4.19659 1.15299 4.25699 1.09501C4.31808 1.03636 4.40514 1 4.49998 1H12.8333C12.9282 1 13.0152 1.03636 13.0763 1.09501C13.1367 1.15299 13.1666 1.22717 13.1666 1.3C13.1666 1.37283 13.1367 1.44701 13.0763 1.50499C13.0152 1.56364 12.9282 1.6 12.8333 1.6ZM12.8333 4.8H4.49998C4.40514 4.8 4.31808 4.76364 4.25699 4.70499C4.19659 4.64701 4.16665 4.57283 4.16665 4.5C4.16665 4.42717 4.19659 4.35299 4.25699 4.29501C4.31808 4.23636 4.40514 4.2 4.49998 4.2H12.8333C12.9282 4.2 13.0152 4.23636 13.0763 4.29501C13.1367 4.35299 13.1666 4.42717 13.1666 4.5C13.1666 4.57283 13.1367 4.64701 13.0763 4.70499C13.0152 4.76364 12.9282 4.8 12.8333 4.8ZM12.8333 8H4.49998C4.40514 8 4.31808 7.96364 4.25699 7.90499C4.19659 7.84701 4.16665 7.77283 4.16665 7.7C4.16665 7.62717 4.19659 7.55299 4.25699 7.49501C4.31808 7.43636 4.40514 7.4 4.49998 7.4H12.8333C12.9282 7.4 13.0152 7.43636 13.0763 7.49501C13.1367 7.55299 13.1666 7.62717 13.1666 7.7C13.1666 7.77283 13.1367 7.84701 13.0763 7.90499C13.0152 7.96364 12.9282 8 12.8333 8Z"
                                        fill="#6B7280" stroke="#6B7280"/>
                                </svg>
                            </div>
                            <input type="text" id="titulo" name="titulo"
                                   class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                   placeholder="Aula sin cuidado..."/>
                        </div>
                        <span id="tituloError" class="text-red-500 text-sm"></span>
                    </div>
                    <!-- Descripción -->
                    <div class="mb-5">
                        <label for="descripcion" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Descripción
                        </label>
                        <textarea id="descripcion" name="descripcion" rows="4"
                                  class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                  placeholder="Se ha observado..."></textarea>
                        <span id="descripcionError" class="text-red-500 text-sm"></span>
                        <div class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="descripcion_hint">
                            Recuerda ser claro y conciso
                        </div>
                    </div>
                    <!-- Actividad a reportar -->
                    {{--                    <div class="mb-5">--}}
                    {{--                        <label for="titulo" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">--}}
                    {{--                            Actividad seleccionada--}}
                    {{--                        </label>--}}

                    {{--                        <div>--}}
                    {{--                            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400 rtl:text-right">--}}
                    {{--                                <thead--}}
                    {{--                                    class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">--}}
                    {{--                                    <tr>--}}
                    {{--                                        <th scope="col" class="px-6 py-3">Nombre</th>--}}
                    {{--                                        <th scope="col" class="px-6 py-3">Escuela</th>--}}
                    {{--                                        <th scope="col" class="px-6 py-3">Aulas</th>--}}
                    {{--                                        <th scope="col" class="px-6 py-3">Asignaturas</th>--}}
                    {{--                                        <th scope="col" class="px-6 py-3">Horario</th>--}}
                    {{--                                    </tr>--}}
                    {{--                                </thead>--}}
                    {{--                                <tbody>--}}
                    {{--                                    <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">--}}
                    {{--                                        <th scope="row"--}}
                    {{--                                            class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">--}}
                    {{--                                            Parcial I--}}
                    {{--                                        </th>--}}
                    {{--                                        <td class="px-6 py-4">Sistemas</td>--}}
                    {{--                                        <td class="px-6 py-4">B11</td>--}}
                    {{--                                        <td class="px-6 py-4">MIP115, COS115</td>--}}
                    {{--                                        <td class="px-6 py-4">8:00 AM - 11:00 PM</td>--}}
                    {{--                                    </tr>--}}
                    {{--                                </tbody>--}}
                    {{--                            </table>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}

                    <!-- Selección de Aula -->
                    <div class="mb-5">
                        <label for="id_aula" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">
                            Seleccionar Aula
                        </label>
                        <select id="id_aula" name="id_aula"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500">
                            <option value="">Seleccione una aula</option>
                            @foreach($aulas as $aula)
                                <option value="{{ $aula->id }}">{{ $aula->nombre }}</option>
                            @endforeach
                        </select>
                        <span id="idAulaError" class="text-red-500 text-sm"></span>
                    </div>

                    <div class="flex justify-center pt-4">
                        <button type="submit"
                                class="w-full rounded-lg bg-red-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 sm:w-auto">
                            Enviar reporte
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('reporteForm').addEventListener('submit', function (event) {
            let isValid = true;
            const titulo = document.getElementById('titulo');
            const descripcion = document.getElementById('descripcion');
            const idAula = document.getElementById('id_aula');

            const tituloError = document.getElementById('tituloError');
            const descripcionError = document.getElementById('descripcionError');
            const idAulaError = document.getElementById('idAulaError');

            // Clear previous error messages
            tituloError.textContent = '';
            descripcionError.textContent = '';
            idAulaError.textContent = '';

            // Validate titulo
            if (titulo.value.trim() === '' || titulo.value.length > 50) {
                isValid = false;
                tituloError.textContent = 'El título es obligatorio y no debe exceder los 50 caracteres.';
            }

            // Validate descripcion
            if (descripcion.value.trim() === '') {
                isValid = false;
                descripcionError.textContent = 'La descripción es obligatoria.';
            }

            // Validate id_aula (optional)
            if (idAula.value !== '' && isNaN(idAula.value)) {
                isValid = false;
                idAulaError.textContent = 'El aula seleccionada no es válida.';
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    </script>
</x-app-layout>
