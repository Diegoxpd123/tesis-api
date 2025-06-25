<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SavePreguntaRequest extends FormRequest
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
            'descripcion' => 'required|string',
            'evaluacionid' => 'required',
            'imagen' => 'required|string',
            'respuesta' => 'required|string',
            'opcion1' => 'required|string',
            'opcion2' => 'required|string',
            'opcion3' => 'required|string',
            'opcion4' => 'required|string',
            'created_at' => 'required',
            'updated_at' => 'required',
            'is_deleted' => 'required',
            'is_actived' => 'required'
            //
        ];
    }
}
