@props(['id'])

<div id="{{ $id }}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
     class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 justify-center items-center w-full h-full md:inset-0">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <div class="flex justify-center w-full">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{ $header }}
                    </h3>
                </div>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                {{ $body }}
            </div>
            <!-- Modal footer -->
            <div
                class="flex items-center justify-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                {{ $footer }}
            </div>
        </div>
    </div>
</div>
