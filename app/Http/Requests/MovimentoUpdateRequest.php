<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovimentoUpdateRequest extends FormRequest
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
            'data' => 'sometimes|required|date|date_format:Y-m-d',
            'hora_descolagem' => 'sometimes|required|date_format:"H:i"',
            'hora_aterragem' => 'sometimes|required|date_format:"H:i"|after:hora_descolagem',
            'aeronave' => 'sometimes|required',
            'num_diario' => 'sometimes|required|integer|min:1',
            'num_servico' => 'sometimes|required|integer|min:1',
            'piloto_id' => 'sometimes|required',
            'natureza' => 'sometimes|required|in:T,I,E',
            'aerodromo_partida' => 'sometimes|required',
            'aerodromo_chegada' => 'sometimes|required',
            'num_aterragens' => 'sometimes|required|integer',
            'num_descolagens' => 'sometimes|required|integer|min:1',
            'num_pessoas' => 'sometimes|required|integer|min:1',
            'conta_horas_inicio' => 'sometimes|required|integer',
            'conta_horas_fim' => 'sometimes|required|integer',
            'tempo_voo' => 'sometimes|required|integer|min:1',
            'preco_voo' => 'sometimes|required|numeric|between:0.0,99999.99',
            'modo_pagamento' => 'sometimes|required|in:N,M,T,P',
            'num_recibo' => 'sometimes|required|min:1',
            'observacoes' => 'nullable',
            'tipo_instrucao' => 'nullable|in:D,S',
            'num_licenca_piloto' => 'sometimes|required|min:3',
            'tipo_licenca_piloto' => 'sometimes|required',
            'validade_licenca_piloto' => 'sometimes|required|date|date_format:Y-m-d|after:today',
            'num_certificado_piloto' => 'sometimes|required,min:3',
            'classe_certificado_piloto' => 'sometimes|required',
            'validade_certificado_piloto' => 'sometimes|required|date|date_format:Y-m-d|after:today',
            'instrutor_id' => 'nullable|integer',
            'tipo_licenca_instrutor' => 'nullable',
            'validade_licenca_instrutor' => 'nullable|date|date_format:Y-m-d|after:today',
            'num_certificado_instrutor' => 'nullable|,min:3',
            'classe_certificado_instrutor' => 'nullable',
            'validade_certificado_instrutor' => 'nullable|date|date_format:Y-m-d|after:today',
            'confirmado' =>  'sometimes|required|in:0,1',
        ];
    }

    public function messages(){
        return [
            'hora_descolagem.after' => 'hora_descolagem tem que ser antes da hora de aterragem',
            'hora_aterragem.before' => 'hora_aterragem tem que ser depois da hora de descolagem',
            'num_diario.integer' => 'O campo num_diario tem que ser um inteiro',
            'num_servico.integer' => 'O campo num_servico tem que ser um inteiro',
            'num_aterragens.integer' => 'O campo num_aterragens tem que ser um inteiro',
            'num_descolagens.integer' => 'O campo num_descolagens tem que ser um inteiro',
            'num_pessoas.integer' => 'O campo num_pessoas tem que ser um inteiro',
            'tempo_voo.integer' => 'O campo tempo_voo tem que ser um inteiro',
            'preco_voo.integer' => 'O campo preco_voo tem que ser um inteiro',
            'preco_voo.between' => 'O campo preco_voo tem que ser entre 0 e 99999.99',
            'modo_pagamento.in' => 'modo_pagamento invalido',
            'validade_licenca_piloto.after' => 'O campo validade_licenca_piloto é invalido (after)',
            'validade_certificado_piloto.after' => 'O campo validade_certificado_piloto é invalido (after)',
            'validade_certificado_instrutor.after' => 'O campo validade_certificado_instrutor é invalido (after)',
            'validade_licenca_instrutor.after' => 'O campo validade_licenca_instrutor é invalido (after)',
        ];
    }
}
