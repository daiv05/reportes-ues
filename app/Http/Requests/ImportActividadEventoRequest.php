<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportActividadEventoRequest extends FormRequest
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
            'fecha' => 'required|array|min:1',
            'fecha.*' => 'date',
            'materia' => 'required|array|min:1',
            'materia.*' => 'exists:asignaturas,nombre',
            'modalidad' => 'required|array|min:1',
            'modalidad.*' => 'exists:modalidades,id',
            'hora_inicio' => 'required|array|min:1',
            'hora_inicio.*' => 'date_format:H:i',
            'hora_fin' => 'required|array|min:1',
            'hora_fin.*' => 'date_format:H:i',
            'evaluacion' => 'required|array|min:1',
            'evaluacion.*' => 'string',
            'cantidad_estudiantes' => 'required|array|min:1',
            'cantidad_estudiantes.*' => 'integer|min:0',
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
            'modalidad.*.exists' => 'La modalidad ingresada no existe',
            'hora_inicio.*.date_format' => 'La hora de inicio debe tener el formato HH:MM',
            'hora_fin.*.date_format' => 'La hora de fin debe tener el formato HH:MM',
            'evaluacion.*.string' => 'La evaluación debe ser una cadena de texto',
            'cantidad_estudiantes.*.integer' => 'La cantidad de estudiantes debe ser un número entero',
            'cantidad_estudiantes.*.min' => 'La cantidad de estudiantes no puede ser negativa',
        ];
    }
}
