<x-forms.button-group>
    <x-forms.primary-button class="ml-3">Filtrar</x-forms.primary-button>
</x-forms.button-group>

<x-forms.row :columns="3">
    <x-forms.select label="Filtrar por Modelo" id="model" name="model" :options="$models->mapWithKeys(
        fn($model) => [$model->auditable_type => class_basename($model->auditable_type)],
    )"
        :selected="request('model')" :error="$errors->get('model')" />

    <div>
        <x-forms.select label="Filtrar por Acción" id="event" name="event" :options="collect($events)->mapWithKeys(
            fn($event) => [
                $event['event'] => ucfirst($event['event']),
            ],
        )"
            :value="old('event')" />
    </div>

    <div>
        <x-forms.field label="Nombre" name="titulo" :value="request('titulo')" />

    </div>
</x-forms.row>

<x-forms.row :columns="2">
        <x-date.date-input name="start_date" label="Fecha Inicial" :maxDate="true" />
        <x-date.date-input name="end_date" label="Fecha Inicial" :maxDate="true"/>
</x-forms.row>
