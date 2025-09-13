<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveEvaluacionRequest extends FormRequest
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
            'nombre' => 'required|string',
            'temaid' => 'required',
            'institucionid' => 'required',
            'fechainicio' => 'required',
            'fechafin' => 'required',
            'grado' => 'required|integer|in:5,6',
            'created_at' => 'required',
            'updated_at' => 'required',
            'is_deleted' => 'required',
            'is_actived' => 'required',
            //
        ];
    }
}
