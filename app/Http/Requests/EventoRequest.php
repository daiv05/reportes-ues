<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventoRequest extends FormRequest
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
        $rules = [
            'evaluacion' => 'required|string',
            'fecha' => 'required|date_format:d/m/Y',
            'materia' => 'required|exists:asignaturas,nombre',
            'modalidad' => 'required|exists:modalidades,id',
            'hora_inicio' => 'date_format:H:i',
            'hora_fin' => 'date_format:H:i',
            'evaluacion' => 'required|string',
            'asistentes' => 'integer|min:1',
            'responsable' => 'required|string',
            'estado' => 'required|in:0,1',
        ];

        if ($this->input('modalidad') == 2) {
            $rules['hora_inicio'] = 'required|date_format:H:i';
            $rules['hora_fin'] = 'required|date_format:H:i';
        } else {
            $rules['hora_inicio'] = 'nullable';
            $rules['hora_fin'] = 'nullable';
        }

        return $rules;
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
            'evaluacion.string' => 'La evaluación debe ser una cadena de texto',
            'cantidad_estudiantes.integer' => 'La cantidad de estudiantes debe ser un número entero',
            'cantidad_estudiantes.min' => 'La cantidad de estudiantes no puede ser negativa',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('modalidad') == 2) {
                $hora_inicio = $this->input('hora_inicio');
                $hora_fin = $this->input('hora_fin');

                $hora_inicio_timestamp = strtotime($hora_inicio);
                $hora_fin_timestamp = strtotime($hora_fin);
                if ($hora_fin_timestamp <= $hora_inicio_timestamp) {
                    $validator->errors()->add('hora_fin', 'La hora de fin debe ser mayor que la hora de inicio.');
                }
            }
        });
    }
}
