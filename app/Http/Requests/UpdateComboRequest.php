<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateComboRequest extends FormRequest
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
            'codigo' => 'required',
            'nombre' => 'required',
            'costo' => 'required|regex:/^\d+(\,\d{1,2})?$/',
            'duracion' => 'required|date|after:today',
            'id_sucursal' => 'required|integer|exists:sucursal,id_sucursal',
            'productos' => 'required|array',
            'productos.*.id_producto' => 'required|integer|exists:producto,id_producto',
            'productos.*.cantidad' => 'required|integer|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'costo.regex' => 'El costo debe ser un número con hasta 2 decimales.',
            'duracion.required' => 'Ingrese una fecha',
            'duracion.after' => 'La fecha de duración debe ser posterior al día actual.',
            'id_sucursal.exists' => 'La sucursal no existe',
            'productos.required' => 'Agregue productos al combo',
            'productos.*.id_producto.exists' => 'No existe el producto',
            'productos.*.cantidad.min' => 'Ingrese un cantidad mayor a 0'
        ];
    }
}
