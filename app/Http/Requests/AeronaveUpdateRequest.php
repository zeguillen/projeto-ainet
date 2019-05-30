<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AeronaveUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'marca' => 'nullable|min:3',
            'modelo' => 'nullable|min:3',
            'num_lugares' => 'nullable',
            'conta_horas' => 'nullable',
            'preco_hora' => 'nullable'
        ];
    }

    public function message(){
        return [
            'matricula.unique' => 'A matricula já se encontra em uso',
            'marca.min' => 'A marca é muito curta',
            'modelo.min' => 'O modelo é muito curto',
        ];
    }
}
