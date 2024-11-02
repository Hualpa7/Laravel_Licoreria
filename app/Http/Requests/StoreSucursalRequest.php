<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSucursalRequest extends FormRequest
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
            'nombre' => 'required|string|max:100',
            'direccion' => 'required|unique:sucursal,direccion|string|max:200',
            'ciudad' => 'required',
            'provincia' => 'required', 
            'foto' => 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'direccion.unique' => 'La direccion ya existe, verifique la misma.'
        ];
    }
}
