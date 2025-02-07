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
        $rules = [
            'fecha' => 'required|array|min:1',
            'fecha.*' => 'date_format:d/m/Y',
            'materia' => 'required|array|min:1',
            'materia.*' => 'exists:asignaturas,nombre|max:10|regex:/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚüÜ]+$/',
            'modalidad' => 'required|array|min:1',
            'modalidad.*' => 'exists:modalidades,id',
            'hora_inicio' => 'required|array|min:1',
            'hora_inicio.*' => 'date_format:H:i',
            'hora_fin' => 'required|array|min:1',
            'hora_fin.*' => 'date_format:H:i',
            'evaluacion' => 'required|array|min:1',
            'evaluacion.*' => 'required|string|max:50|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s\/-]+$/',
            'cantidad_estudiantes' => 'required|array|min:1',
            'cantidad_estudiantes.*' => 'integer|min:0',
            'responsable' => 'required|array|min:1',
            'responsable.*' => 'required|string|max:50|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ\s]+$/',
            'comentarios' => 'nullable|array',
            'comentarios.*' => 'nullable|string|max:250|regex:/^[a-zA-Z0-9.,ñÑáéíóúÁÉÍÓÚüÜ\s]+$/',
        ];

        foreach ($this->input('modalidad', []) as $key => $value) {
            if ($value == 2) {
                $rules["hora_inicio.$key"] = 'required|date_format:H:i';
                $rules["hora_fin.$key"] = 'required|date_format:H:i';
            } else {
                $rules["hora_inicio.$key"] = 'nullable';
                $rules["hora_fin.$key"] = 'nullable';
            }
        }

        return $rules;
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
            'materia.*.max' => 'La materia no puede tener más de 10 caracteres',
            'materia.*.regex' => 'La materia solo acepta letras y números',
            'modalidad.*.exists' => 'La modalidad ingresada no existe',
            'hora_inicio.*.date_format' => 'La hora de inicio debe tener el formato HH:MM',
            'hora_fin.*.date_format' => 'La hora de fin debe tener el formato HH:MM',
            'hora_inicio.*.required' => 'La hora de inicio es requerida en modalidad presencial',
            'hora_fin.*.required' => 'La hora de fin es requerida en modalidad presencial',
            'evaluacion.*.string' => 'La evaluación debe ser una cadena de texto',
            'evaluacion.*.required' => 'La evaluación es requerida',
            'evaluacion.*.regex' => 'La evaluación solo acepta letras, números, plecas, guiones y espacios',
            'evaluacion.*.max' => 'La evaluación no puede tener más de 50 caracteres',
            'cantidad_estudiantes.*.integer' => 'La cantidad de estudiantes debe ser un número entero',
            'cantidad_estudiantes.*.min' => 'La cantidad de estudiantes no puede ser negativa',
            'responsable.*.required' => 'El responsable es requerido',
            'responsable.*.string' => 'El responsable debe ser una cadena de texto',
            'responsable.*.max' => 'El responsable no puede tener más de 50 caracteres',
            'responsable.*.regex' => 'El responsable solo acepta letras, números y espacios',
            'comentarios.*.string' => 'El comentario debe ser una cadena de texto',
            'comentarios.*.max' => 'El comentario no puede tener más de 250 caracteres',
            'comentarios.*.regex' => 'El comentario solo acepta letras, números y espacios',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $hora_inicio = $this->input('hora_inicio');
            $hora_fin = $this->input('hora_fin');
            $modalidad = $this->input('modalidad');

            foreach ($modalidad as $index => $hora_inicio_value) {
                // Verificar que la hora de fin sea mayor que la hora de inicio
                $hora_inicio_timestamp = strtotime($hora_inicio[$index]);
                $hora_fin_timestamp = strtotime($hora_fin[$index]);

                if ($hora_fin_timestamp <= $hora_inicio_timestamp && $modalidad[$index] == 2) {
                    $validator->errors()->add('hora_fin.' . $index, 'La hora de fin debe ser mayor que la hora de inicio.');
                }
            }
        });
    }
}
