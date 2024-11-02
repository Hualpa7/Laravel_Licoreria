<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVentaRequest extends FormRequest
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
            'neto' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'metodo_pago' => 'required|string|max:50',
            'descuento_total' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'id_usuario' => 'required|integer|exists:usuario,id_usuario',
            'id_sucursal' => 'required|integer|exists:sucursal,id_sucursal'
        ];
    }

    public function messages(): array
    {
        return [
            'neto.regex' => 'El valor debe ser un numero decimal con 2 decimales',
            'metodo_pago.required' => 'Ingrese metodo de pago',
            'descuento_total.regex' => 'El valor debe ser un numero decimal con 2 decimales',
            'id_usuario.exists' => 'El usuario que realizo la venta no existe',
            'id_sucursal.exists' => 'La sucursal no existe'
        ];
    }
}
