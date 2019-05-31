<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AeronaveStorageRequest extends FormRequest
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
            'matricula' => 'required|unique:aeronaves,matricula',
            'marca' => 'required|min:3',
            'modelo' => 'required|min:3',
            'num_lugares' => 'required|integer',
            'conta_horas' => 'required|integer',
            'preco_hora' => 'required|numeric'
        ];
    }

    public function message(){
        return [
            'matricula.required' => 'A matricula é requerida',
            'matricula.unique' => 'A matricula já existe',
            'marca.required' => 'A marca é requerida',
            'marca.min' => 'A marca é muito curta',
            'modelo.required' => 'O modelo é requerido',
            'modelo.min' => 'O modelo é muito curto',
            'num_lugares.required' => 'O número de lugares é requerido',
            'num_lugares.numeric' => 'O número de lugares é inválido',
            'conta_horas.required' => 'O conta horas é requerido',
            'conta_horas.numeric' => 'O conta horas é inválido',
            'preco_hora.required' => 'O preco por hora é requerido',
            'preco_hora.numeric' => 'O preco por hora é inválido'
        ];
    }
}
