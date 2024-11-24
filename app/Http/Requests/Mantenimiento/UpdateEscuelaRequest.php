<?php

namespace App\Http\Requests\Mantenimiento;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEscuelaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $nombreRule = 'required|max:50';
        $escuela = $this->route('id');
        if ($escuela && $escuela != $this->nombre) {
            $nombreRule .= '|unique:escuelas,nombre,' . $escuela;
        }

        return [
            'id_facultad' => 'required|exists:facultades,id',
            'nombre' => $nombreRule,
            'activo' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'id_facultad.required' => 'El campo de facultad es obligatorio.',
            'id_facultad.exists' => 'La facultad seleccionada no existe en nuestra base de datos.',
            'nombre.required' => 'El nombre de la escuela es obligatorio.',
            'nombre.max' => 'El nombre de la escuela no debe exceder los 50 caracteres.',
            'nombre.unique' => 'El nombre de la escuela ya existe. Por favor, elige otro nombre.',
            'activo.required' => 'El campo de estado activo es obligatorio.',
            'activo.boolean' => 'El campo de estado activo debe ser verdadero o falso.',
        ];
    }
}
