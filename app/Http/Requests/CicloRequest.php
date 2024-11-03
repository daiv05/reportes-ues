<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\General\Ciclo;

class CicloRequest extends FormRequest
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
            'anio' => [
                'required',
                'integer',
                // Validación única para la combinación de anio y id_tipo_ciclo
                function ($attribute, $value, $fail) {
                    $exists = Ciclo::where('anio', $value)
                        ->where('id_tipo_ciclo', $this->id_tipo_ciclo)
                        ->exists();

                    if ($exists) {
                        $fail('Ya existe un ciclo para el año y tipo de ciclo seleccionados.');
                    }
                },
            ],
            'id_tipo_ciclo' => 'required|exists:tipos_ciclos,id',
            'activo' => 'boolean',
        ];
    }

}
