<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovimentoStorageRequest extends FormRequest
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
            'aeronave' => 'required', 
            'data' => 'required|date|date_format:Y-m-d', 
            'hora_descolagem' => 'required', 
            'hora_aterragem' => 'required|', 
            'tempo_voo' => 'required|', 
            'natureza' => 'required|in: T, I, E', 
            'piloto_id' => 'required|', 
            'aerodromo_partida' => 'required|', 
            'aerodromo_chegada' => 'required|', 
            'num_aterragens' => 'required|',
            'num_descolagens' => 'required|', 
            'num_diario' => 'required|', 
            'num_servico' => 'required|', 
            'conta_horas_inicio' => 'required|', 
            'conta_horas_fim' => 'required|', 
            'num_pessoas' => 'required|', 
            'tipo_instrucao' => 'nullable|required_if: natureza, I', 
            'instrutor_id' => 'nullable|required_with: tipo_instrucao', 
            'observacoes' => 'nullable|', 
            'modo_pagamento' => 'required|', 
            'num_recibo' => 'required|'
        ];
    }
}
