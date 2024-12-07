<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClaseRequest extends FormRequest
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
            'materia' => 'required|exists:asignaturas,nombre',
            'tipo' => 'required|exists:tipo_clases,id',
            'modalidad' => 'required|exists:modalidades,id',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'grupo' => 'required|integer|min:1',
            'responsable' => 'required|string',
            'dias' => 'required|array',
            'dias.*' => 'required|integer|between:1,7',
            'estado' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'materia.exists' => 'La materia ingresada no existe',
            'modalidad.exists' => 'La modalidad ingresada no existe',
            'hora_inicio.date_format' => 'La hora de inicio debe tener el formato HH:MM',
            'hora_fin.date_format' => 'La hora de fin debe tener el formato HH:MM',
            'hora_inicio.required' => 'La hora de inicio es requerida en modalidad presencial',
            'hora_fin.required' => 'La hora de fin es requerida en modalidad presencial',
            'grupo.integer' => 'El grupo debe ser un número entero',
            'grupo.min' => 'El grupo no puede ser negativo',
            'responsable.string' => 'El responsable debe ser una cadena de texto',
            'dias.required' => 'Los días de la actividad son requeridos',
            'dias.array' => 'Los días deben ser un arreglo',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $hora_inicio = $this->input('hora_inicio');
            $hora_fin = $this->input('hora_fin');

            $hora_inicio_timestamp = strtotime($hora_inicio);
            $hora_fin_timestamp = strtotime($hora_fin);
            if ($hora_fin_timestamp <= $hora_inicio_timestamp) {
                $validator->errors()->add('hora_fin', 'La hora de fin debe ser mayor que la hora de inicio.');
            }
        });
    }
}
