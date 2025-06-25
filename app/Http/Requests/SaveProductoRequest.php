<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveProductoRequest extends FormRequest
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
            'talla' => 'required',
            'color' => 'required|string',
            'nombre' => 'required',
            'descripcion' => 'required',
            'stock' => 'required|string',
            'price' => 'required',
            'image' => 'required',
            'is_deleted' => 'required',
            'is_actived' => 'required',
            'created_at' => 'required',
            'updated_at' => 'required'
        ];
    }
}
