<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
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
            'apellido' => 'required|string|max:100',
            'dni' => 'required|unique:usuario,dni|integer',
            'contraseña' => 'required',
            'id_rol' => 'required|integer|exists:roles,id_rol',
            'id_sucursal' => 'nullable|integer|exists:sucursal,id_sucursal',
            'correo' => 'required|unique:usuario,correo|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z]+\.[a-zA-Z]{2,3}$/'
        ];
    }

    public function messages(): array
    {
        return [
            'dni.unique' => 'El DNI ya existe, verifique el  mismo.',
            'id_rol.exists' => 'El rol seleccionado no existe.',
            'id_sucursal.exists' => 'La sucursal seleccionada no existe.',
            'correo.unique' => 'El Correo ya existe, ingrese uno diferente.',
            'correo.regex' => 'Formato de correo no valido'
        ];
    }
}
