<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProveedorRequest extends FormRequest
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
            'nombre' => 'required|max:100',
            'telefono' => 'required|unique:proveedor,telefono|regex:/^\d{3,4}-\d{6,7}$/',
            'correo' => 'required|unique:proveedor,correo|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z]+\.[a-zA-Z]{2,3}$/'
        ];
    }

    public function messages(): array
    {
        return [
            'telefono.unique' => 'El Telefono ya existe, ingrese uno diferente.',
            'telefono.regex' =>  'Formato de telefono no valido',
            'correo.unique' => 'El Correo ya existe, ingrese uno diferente.',
            'correo.regex' => 'Formato de correo no valido'
        ];
    }
}
