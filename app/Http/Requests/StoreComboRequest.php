<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComboRequest extends FormRequest
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
            'nombre' => 'required|string|max:50|unique:combo,nombre',
            'costo' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'duracion' => 'required|date|after:today',
            'id_sucursal' => 'required|integer|exists:sucursal,id_sucursal'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.unique' => 'El combo con ese nombre ya existe. Intente con otro',
            'costo.regex' => 'El costo debe ser un número con hasta 2 decimales.',
            'duracion.required' => 'Ingrese una fecha',
            'duracion.after' => 'La fecha de duración debe ser posterior al día actual.',
            'id_sucursal.exists' => 'La sucursal no existe'
        ];
    }
}
