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
            <div class="mt-4 w-full">
                <label for="recursos_utilizados"
                       class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recursos utilizados</label>
                <select multiple="" data-hs-select='{
  "hasSearch": true,
  "isSearchDirectMatch": false,
  "searchPlaceholder": "Search...",
  "searchClasses": "block w-full text-sm border-gray-200 rounded-lg focus:border-blue-500 focus:ring-blue-500 before:absolute before:inset-0 before:z-[1] dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 py-2 px-3",
  "searchWrapperClasses": "bg-white p-2 -mx-1 sticky top-0 dark:bg-neutral-900",
  "placeholder": "Select multiple options...",
  "toggleTag": "<button type=\"button\" aria-expanded=\"false\"></button>",
  "toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex gap-x-2 text-nowrap w-full cursor-pointer bg-white border border-gray-200 rounded-lg text-start text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-neutral-600",
  "dropdownClasses": "mt-2 z-50 w-full max-h-72 p-1 space-y-0.5 bg-white border border-gray-200 rounded-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500 dark:bg-neutral-900 dark:border-neutral-700",
  "optionClasses": "py-2 px-4 w-full text-sm text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100 dark:bg-neutral-900 dark:hover:bg-neutral-800 dark:text-neutral-200 dark:focus:bg-neutral-800",
  "optionTemplate": "<div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div><div class=\"hs-selected:font-semibold text-sm text-gray-800 \" data-title></div></div><div class=\"ms-auto\"><span class=\"hidden hs-selected:block\"><svg class=\"shrink-0 size-4 text-blue-600\" xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" viewBox=\"0 0 16 16\"><path d=\"M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z\"/></svg></span></div></div>",
  "extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-gray-500 \" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
}' class="hidden">
                    <option value="">Choose</option>
                    @foreach ($recursos as $recurso)
                        <option value="{{ $recurso->id }}">
                            {{ $recurso->nombre }}
                        </option>
                    @endforeach
                </select>
                @include('components.forms.input-error', [
                    'messages' => $errors->get('recursos'),
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

