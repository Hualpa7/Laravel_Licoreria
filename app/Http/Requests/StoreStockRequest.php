<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStockRequest extends FormRequest
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
            'cantidad' => 'required|integer',
            'tipo' => 'required|string|max:50',
            'observaciones' => 'nullable',
            'id_producto' => 'required|integer|exists:producto,id_producto',
            'id_compra' => 'nullable|integer|exists:compra,id_compra',
            'id_venta' => 'nullable|integer|exists:venta,id_venta',
            'id_sucursal' => 'required|integer|exists:sucursal,id_sucursal',
            'id_transferencia' => 'nullable|integer'
        ];
    }

    public function messages(): array
    {
        return [
            'id_sucursal.exists' => 'La sucursal no existe',
            'id_producto.exists' => 'El producto no existe',
            'id_compra.exists' => 'La compra no existe',
            'id_venta.exists' => 'La venta no existe',
        ];
    }
}
