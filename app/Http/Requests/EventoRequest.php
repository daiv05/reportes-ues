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
            'evaluacion' => 'required|string|max:50|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s]+$/',
            'fecha' => 'required|date_format:d/m/Y',
            'materia' => 'required|exists:asignaturas,nombre|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ]+$/',
            'modalidad' => 'required|exists:modalidades,id',
            'hora_inicio' => 'date_format:H:i',
            'hora_fin' => 'date_format:H:i',
            'evaluacion' => 'required|string',
            'asistentes' => 'integer|min:1',
            'responsable' => 'required|string|max:50|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s]+$/',
            'estado' => 'required|in:0,1',
            'comentario' => 'max:250',
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
            'evaluacion.required' => 'La evaluación es requerida',
            'evaluacion.max' => 'La evaluación debe tener un máximo de 50 caracteres',
            'evaluacion.regex' => 'La evaluación solo acepta letras, números y espacios',
            'materia.exists' => 'La materia ingresada no existe',
            'materia.regex' => 'La materia solo acepta letras y números',
            'modalidad.exists' => 'La modalidad ingresada no existe',
            'responsable.regex' => 'El responsable solo acepta letras, números y espacios',
            'responsable.max' => 'El responsable debe tener un máximo de 50 caracteres',
            'hora_inicio.date_format' => 'La hora de inicio debe tener el formato HH:MM',
            'hora_fin.date_format' => 'La hora de fin debe tener el formato HH:MM',
            'hora_inicio.required' => 'La hora de inicio es requerida en modalidad presencial',
            'hora_fin.required' => 'La hora de fin es requerida en modalidad presencial',
            'evaluacion.string' => 'La evaluación debe ser una cadena de texto',
            'cantidad_estudiantes.integer' => 'La cantidad de estudiantes debe ser un número entero',
            'cantidad_estudiantes.min' => 'La cantidad de estudiantes no puede ser negativa',
            'comentarios.max' => 'Los comentarios deben tener un máximo de 250 caracteres',
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
