<?php

namespace App\Http\Requests\Mantenimiento;

use Illuminate\Foundation\Http\FormRequest;

class StoreAulaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_facultad' => 'required|exists:facultades,id',
            'nombre' => 'required|max:50|regex:/^[a-zA-Z0-9.ñÑáéíóúÁÉÍÓÚüÜ]+$/|unique:aulas,nombre,NULL,id,id_facultad,' . $this->id_facultad,
            'activo' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'id_facultad.required' => 'El campo de facultad es obligatorio.',
            'id_facultad.exists' => 'La facultad seleccionada no existe en nuestra base de datos.',
            'nombre.required' => 'El nombre del aula es obligatorio.',
            'nombre.max' => 'El nombre del aula no debe exceder los 50 caracteres.',
            'nombre.regex' => 'El nombre solo puede contener letras y números.',
            'nombre.unique' => 'Ya existe un aula con este nombre en la facultad seleccionada.',
            'activo.required' => 'El campo de estado activo es obligatorio.',
            'activo.boolean' => 'El campo de estado activo debe ser verdadero o falso.',
        ];
    }
}
