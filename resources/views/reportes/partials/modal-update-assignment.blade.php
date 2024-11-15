<x-modal name="actualizar-seguimiento-modal" :show="false" maxWidth="xl">
    <form method="POST" action="{{ route('reportes.actualizarEstado', ['id' => $reporte->id]) }}"
        enctype="multipart/form-data">
        @csrf
        <div class="p-6 flex flex-col items-center w-full">
            <h2 class="text-lg font-medium text-escarlata-ues dark:text-gray-100">
                Actualizar seguimiento de reporte
            </h2>
            <div class="mt-4 w-full">
                <label for="id_estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Actualizar
                    a</label>
                <select id="id_estado" name="id_estado"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Seleccionar estado</option>
                    @foreach ($estadosPermitidos as $estado)
                        <option value="{{ $estado->id }}">{{ $estado->nombre }}</option>
                    @endforeach
                </select>
                @include('components.forms.input-error', [
                    'messages' => $errors->get('id_estado'),
                ])
            </div>
            <div class="mt-4 w-full">
                <label for="comentarios"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Comentarios</label>
                <textarea id="comentarios" name="comentario" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                @include('components.forms.input-error', [
                    'messages' => $errors->get('comentario'),
                ])
            </div>
            <div class="mt-4 w-full">
                <label for="evidencia"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Evidencia</label>
                <input type="file" id="evidencia" name="evidencia"
                    class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-300 border border-gray-300 rounded-md cursor-pointer focus:outline-none focus:border-indigo-500 focus:ring-indigo-500">
                @include('components.forms.input-error', [
                    'messages' => $errors->get('evidencia'),
                ])
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
