<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDescuentoRequest extends FormRequest
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
            'duracion' => 'required|date|after:today',
            'porcentaje' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            'duracion.after' => 'La fecha de duración debe ser posterior al día actual.',
            'porcentaje.required' => 'Ingrese porcentaje.'
        ];
    }
}
