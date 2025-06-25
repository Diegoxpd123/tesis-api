<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveResultadoPreguntaRequest extends FormRequest
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
        'alumnoid'      => 'required|integer',
        'preguntaid'    => 'required|integer',
        'cursoid'       => 'required|integer',
        'temaid'        => 'required|integer',
        'institucionid' => 'required|integer',
        'respuesta'     => 'required|string',
        'tiempo'        => 'required|integer',
        'tiemporeforzamiento'        => 'required|integer',
        'created_at'    => 'required|string',
        'updated_at'    => 'required|string',
        'is_deleted'    => 'required|integer',
        'is_actived'    => 'required|integer',
        'isexamen'    => 'integer',
    ];
    }
}
