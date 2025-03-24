<x-modal name="confirm-modal" :show="false" maxWidth="md" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 justify-center items-center w-full h-full md:inset-0">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <form id="marcarNoProcede" method="POST" action="{{ route('reportes.noProcede', ['id' => $reporte->id]) }}">
            @csrf
            @method('PUT')
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Confirmación
                </h2>
                <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                    ¿Estás seguro de que deseas marcar este reporte como "No procede"? Esto finalizará el proceso y no se podrá revertir.
                </p>
            </div>

            <label for="txtNoProcede" class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">Detalle el motivo</label>
            <textarea id="txtNoProcede" name="txtNoProcede" required
                rows="4" class="block p-2.5 w-full text-lg text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Detalla el motivo..."></textarea>


            <div id="message-error" class="text-sm text-red-500 hidden">
                Este campo es obligatorio.
            </div>

            <div class="flex justify-end px-6 py-4 dark:bg-gray-800 text-right">
                <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded"
                    x-on:click="$dispatch('close-modal', 'confirm-modal')">
                    Cancelar
                </button>
                <button type="submit" id="confirmMarcarNoProcede" class="bg-red-700 text-white px-4 py-2 rounded ml-2">
                    Confirmar
                </button>
            </div>
        </form>
    </div>
</x-modal>

<script>
    const form = document.getElementById('marcarNoProcede');
    const messageField = document.getElementById('message');
    const errorMessage = document.getElementById('message-error');

    form.addEventListener('submit', function(event) {
        if (!messageField.value.trim()) {
            event.preventDefault();
            errorMessage.classList.remove('hidden');
        }
    });
    messageField.addEventListener('input', function() {
        if (messageField.value.trim()) {
            errorMessage.classList.add('hidden');
        }
    });
</script>
