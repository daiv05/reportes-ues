<?php

namespace App\Http\Requests;

use App\Models\Seguridad\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules()
    {
        return [
            'nombre' => 'required|string|max:100|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/',
            'apellido' => 'required|string|max:100|regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ\s]+$/',
            'fecha_nacimiento' => 'required|date_format:d/m/Y',
            'telefono' => 'required|string|max:50|regex:/^\+?(\d{1,4})?[-.\s]?(\(?\d{2,4}\)?)?[-.\s]?\d{3,4}[-.\s]?\d{4}$/',
            'carnet' => 'required|string|max:50|regex:/^(?!.*[._])?[a-zA-Z0-9](?:[a-zA-Z0-9._]{2,18}[a-zA-Z0-9])?$/|unique:users,carnet,' . $this->user()->id,
            'email' => 'required|email|max:255|unique:users,email,' . $this->user()->id,
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */

    public function messages()
    {
        return [
            'nombre.regex' => 'El campo nombre solo puede contener letras y espacios.',
            'apellido.regex' => 'El campo apellido solo puede contener letras y espacios.',
            'fecha_nacimiento.date_format' => 'El campo fecha de nacimiento no tiene un formato válido.',
            'telefono.regex' => 'El campo teléfono no tiene un formato válido.',
            'carnet.regex' => 'El campo carnet no tiene un formato válido.',
            'email.unique' => 'El correo electrónico ya está en uso.',
            'carnet.unique' => 'El carnet ya está en uso.',
        ];
    }
}
