<x-modal name="confirm-modal" :show="false" maxWidth="md">
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
        <div class="flex justify-end px-6 py-4 bg-gray-100 dark:bg-gray-800 text-right">
            <button class="bg-gray-500 text-white px-4 py-2 rounded"
                x-on:click="$dispatch('close-modal', 'confirm-modal')">
                Cancelar
            </button>
            <button type="submit" id="confirmMarcarNoProcede" class="bg-red-700 text-white px-4 py-2 rounded ml-2">
                Confirmar
            </button>
        </div>
    </form>
</x-modal>
