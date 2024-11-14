<x-modal name="confirm-modal" :show="false" maxWidth="md">
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Confirmación
        </h2>
        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
            ¿Estás seguro de que deseas marcar este reporte como "No procede"?
        </p>
    </div>
    <div class="flex justify-end px-6 py-4 bg-gray-100 dark:bg-gray-800 text-right">
        <button class="bg-gray-500 text-white px-4 py-2 rounded" x-on:click="$dispatch('close-modal', 'confirm-modal')">
            Cancelar
        </button>
        <button id="confirmMarcarNoProcede" class="bg-red-700 text-white px-4 py-2 rounded ml-2">
            Confirmar
        </button>
    </div>
</x-modal>
<script>
    document.getElementById('confirmMarcarNoProcede').addEventListener('click', function() {
        const idReporte = window.location.pathname.split('/').pop(); // Obtener el ID del reporte desde la URL

        axios.put(`/reportes/marcar-no-procede/${idReporte}`, {}, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                }
            })
            .then(response => {
                if (response.data.message) {
                    alert(response.data.message);
                }
                window.location.reload();
            })
            .catch(error => console.error('Error:', error));
    });
</script>
