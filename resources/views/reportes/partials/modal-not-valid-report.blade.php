<x-modal
    name="confirm-modal"
    :show="false"
    maxWidth="lg"
    class="fixed inset-0 z-50 hidden h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
>
    <div class="relative max-h-full p-4">
        <form id="marcarNoProcede" method="POST" action="{{ route('reportes.noProcede', ['id' => $reporte->id]) }}">
            @csrf
            @method('PUT')
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 text-center">Confirmación</h2>
                <p class="my-4 text-sm text-gray-600 dark:text-gray-400">
                    ¿Estás seguro de que deseas marcar este reporte como "No procede"? Esto finalizará el proceso y no
                    se podrá revertir.
                </p>
                {{--
                    <label for="txtNoProcede" class="mb-2 block text-md font-medium text-gray-900 dark:text-white">
                    Justificación
                    </label>
                --}}
                <textarea
                    id="justificacion"
                    name="justificacion"
                    required
                    rows="4"
                    class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-red-500 focus:ring-red-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-red-500 dark:focus:ring-red-500"
                    placeholder="Detalla la razón..."
                ></textarea>

                <div id="message-error" class="hidden text-sm text-red-500">Este campo es obligatorio.</div>
            </div>
            <div class="flex justify-end px-6 py-4 text-right dark:bg-gray-800">
                <button
                    type="button"
                    class="rounded bg-gray-500 px-4 py-2 text-white"
                    x-on:click="$dispatch('close-modal', 'confirm-modal')"
                >
                    Cancelar
                </button>
                <button type="submit" id="confirmMarcarNoProcede" class="ml-2 rounded bg-red-700 px-4 py-2 text-white">
                    Confirmar
                </button>
            </div>
        </form>
    </div>
</x-modal>

<script>
    const form = document.getElementById('marcarNoProcede');
    const messageField = document.getElementById('justificacion');
    const errorMessage = document.getElementById('message-error');

    form.addEventListener('submit', function (event) {
        if (!messageField.value.trim()) {
            event.preventDefault();
            errorMessage.classList.remove('hidden');
        }
    });
    messageField.addEventListener('input', function () {
        if (messageField.value.trim()) {
            errorMessage.classList.add('hidden');
        }
    });
</script>
