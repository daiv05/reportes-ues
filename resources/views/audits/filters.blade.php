<div class="flex w-full flex-col px-4 md:w-5/6 md:px-0">
    <x-forms.row :columns="3">
        <x-forms.select label="Filtrar por Modelo" id="model" name="model" :options="$models->mapWithKeys(
            fn($model) => [$model->auditable_type => class_basename($model->auditable_type)],
        )" :selected="request('model')"
            :error="$errors->get('model')" />

        <div>
            <x-forms.select label="Filtrar por Acción" id="event" name="event" :options="collect($events)->mapWithKeys(
                fn($event) => [
                    $event['event'] => ucfirst($event['event']),
                ],
            )" :value="old('event')" />
        </div>

        <div>
            <x-forms.field label="Nombre" name="titulo" :value="request('titulo')" />

        </div>
        <x-date.date-input name="start_date" label="Fecha Inicial" :maxDate="true" />
        <x-date.date-input name="end_date" label="Fecha Final" :maxDate="true" />
    </x-forms.row>

</div>
<div class="relative flex flex-wrap space-x-4">
    <button type="submit" data-tooltip-target="tooltip-aplicar-filtros"
        class="inline-flex items-center rounded-full border border-transparent bg-escarlata-ues px-3 py-3 align-middle text-sm font-medium text-white shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
    </button>

    <div id="tooltip-aplicar-filtros" role="tooltip"
        class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-escarlata-ues px-3 py-2 !text-center text-sm font-medium text-white opacity-0 transition-opacity duration-300 dark:bg-gray-700">
        Aplicar filtros
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>

    <button type="reset"
        class="inline-flex items-center rounded-full border border-gray-500 bg-white px-3 py-3 align-middle text-sm font-medium text-gray-500 shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
        onclick="window.location.href='{{ route('general.index') }}';"
        data-tooltip-target="tooltip-limpiar-filtros">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <div id="tooltip-limpiar-filtros" role="tooltip"
        class="shadow-xs tooltip z-40 inline-block !text-nowrap rounded-lg bg-gray-200 px-3 py-2 !text-center text-sm font-medium text-escarlata-ues opacity-0 transition-opacity duration-300 dark:bg-gray-700">
        Limpiar filtros
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
</div>
