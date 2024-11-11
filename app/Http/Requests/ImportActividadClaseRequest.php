<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportActividadClaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'materia' => 'required|array|min:1',
            'materia.*' => 'exists:asignaturas,nombre',
            'tipo' => 'required|array|min:1',
            'tipo*' => 'exists:tipo_clases,id',
            'grupo' => 'required|array|min:1',
            'grupo.*' => 'integer|min:1',
            'modalidad' => 'required|array|min:1',
            'local' => 'required|array|min:1',
            'local.*' => 'exists:aulas,nombre',
            'modalidad.*' => 'exists:modalidades,id',
            'hora_inicio' => 'required|array|min:1',
            'hora_inicio.*' => 'date_format:H:i',
            'hora_fin' => 'required|array|min:1',
            'hora_fin.*' => 'date_format:H:i',
            'diasActividad' => 'required|array|min:1',
            'diasActividad.*' => 'required|array|min:1',
            'diasActividad.*.*' => 'exists:dias,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */

    public function messages(): array
    {
        return [
            'materia.*.exists' => 'La materia ingresada no existe',
            'tipo.*.exists' => 'El tipo de clase ingresado no existe',
            'modalidad.*.exists' => 'La modalidad ingresada no existe',
            'hora_inicio.*.date_format' => 'La hora de inicio debe tener el formato HH:MM',
            'hora_fin.*.date_format' => 'La hora de fin debe tener el formato HH:MM',
            'diasActividad.*.required' => 'Debe seleccionar al menos un día para la actividad',
            'diasActividad.*.*.exists' => 'El día seleccionado no existe',
            'local.*.exists' => 'El local ingresado no existe',
        ];
    }
}
