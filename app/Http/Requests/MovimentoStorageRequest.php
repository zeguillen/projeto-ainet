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
            'data' => 'required|date|date_format:Y-m-d',
            'hora_descolagem' => 'required|date|date_format"H:i"|before:hora_aterragem',
            'hora_aterragem' => 'required|date|date_format"H:i"|after:hora_descolagem',
            'aeronave' => 'required',
            'num_diario' => 'required|integer',
            'num_servico' => 'required|integer',
            'piloto_id' => 'required',
            'num_licenca_piloto' => 'required',
            'validade_licenca_piloto' => 'required|date|date_format:Y-m-d|after:today',
            'tipo_licenca_piloto' => 'required',
            'num_certificado_piloto' => 'required',
            'validade_certificado_piloto' => 'required|date|date_format:Y-m-d|after:today',
            'classe_certificado_piloto' => 'required',
            'natureza' => 'required|in:T,I,E',
            'aerodromo_partida' => 'required',
            'aerodromo_chegada' => 'required',
            'num_aterragens' => 'required|integer',


            'tempo_voo' => 'required|date|date_format:"H:i',
            'num_descolagens' => 'required|',
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
