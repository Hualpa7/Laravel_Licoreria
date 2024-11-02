<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriaRequest extends FormRequest
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
             'nombre_categoria' => 'required|unique:categoria,nombre_categoria|max:100'
             /*function ($attribute, $value, $fail) {
                    $nombreCategoriaLower = strtolower($value);
                    if (Categoria::whereRaw('LOWER(nombre_categoria) = ?', [$nombreCategoriaLower])->exists()) {
                        $fail('La categoria ya existe, ingrese una diferente.');
                    }
                },*/ 
        ];
    }


    public function messages(): array
    {
        return [
            'nombre_categoria.unique' => 'La categoria ya existe, ingrese una diferente.'
        ];
    }
}
