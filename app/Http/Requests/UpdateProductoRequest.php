<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductoRequest extends FormRequest
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
        $productoId = $this->route('id');

        return [
            'alerta_minima' => 'required|integer', // Debe ser un entero
            'costo' => 'required|regex:/^\d+(\,\d{1,2})?$/',
            'id_marca' => 'required|integer|exists:marca,id_marca',
            'id_categoria' => 'required|integer|exists:categoria,id_categoria',

        ];
    }
}
