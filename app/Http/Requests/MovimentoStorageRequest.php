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
            'hora_descolagem' => 'required|date_format:"H:i"',
            'hora_aterragem' => 'required|date_format:"H:i"|after:hora_descolagem',
            'aeronave' => 'required',
            'num_diario' => 'required|integer',
            'num_servico' => 'required|integer',
            'piloto_id' => 'required',
            'natureza' => 'required|in:T,I,E',
            'aerodromo_partida' => 'required',
            'aerodromo_chegada' => 'required',
            'num_aterragens' => 'required|integer',
            'num_descolagens' => 'required|integer',
            'num_pessoas' => 'required|integer',
            'conta_horas_inicio' => 'required|integer',
            'conta_horas_fim' => 'required|integer',
            'tempo_voo' => 'required|integer',
            'preco_voo' => 'required|numeric|between:0.0,99999.99',
            'modo_pagamento' => 'required|in:N,M,T,P',
            'num_recibo' => 'required|min:1',
            'observacoes' => 'nullable',
            'tipo_instrucao' => 'nullable|in:D,S|required_if:natureza,I',
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
            'tipo_conflito' => 'sometimes|required|in:S,B',
            'justificacao_conflito' => 'sometimes|required|min:10'
        ];
    }

    public function messages(){
        return [
            'data.required' => 'O campo data é requerido',
            'hora_descolagem.required' => 'O campo hora_descolagem é requerido',
            'hora_descolagem.after' => 'hora_descolagem tem que ser antes da hora de aterragem',
            'hora_aterragem.required' => 'O campo hora_aterragem é requerido',
            'hora_aterragem.before' => 'hora_aterragem tem que ser depois da hora de descolagem',
            'aeronave.required' => 'O campo aeronave é requerido',
            'num_diario.required' => 'O campo num_diario é requerido',
            'num_diario.integer' => 'O campo num_diario tem que ser um inteiro',
            'num_servico.required' => 'O campo num_servico é requerido',
            'num_servico.integer' => 'O campo num_servico tem que ser um inteiro',
            'piloto_id.required' => 'O campo piloto_id é requerido',
            'natureza.required' => 'O campo natureza é requerido',
            'aerodromo_partida.required' => 'O campo aerodromo_partida é requerido',
            'aerodromo_chegada.required' => 'O campo aerodromo_chegada é requerido',
            'num_aterragens.required' => 'O campo num_aterragens é requerido',
            'num_aterragens.integer' => 'O campo num_aterragens tem que ser um inteiro',
            'num_descolagens.required' => 'O campo num_descolagens é requerido',
            'num_descolagens.integer' => 'O campo num_descolagens tem que ser um inteiro',
            'num_pessoas.required' => 'O campo num_pessoas é requerido',
            'num_pessoas.integer' => 'O campo num_pessoas tem que ser um inteiro',
            'conta_horas_inicio.required' => 'O campo conta_horas_inicio é requerido',
            'conta_horas_fim.required' => 'O campo conta_horas_fim é requerido',
            'tempo_voo.required' => 'O campo tempo_voo é requerido',
            'tempo_voo.integer' => 'O campo tempo_voo tem que ser um inteiro',
            'preco_voo.required' => 'O campo preco_voo é requerido',
            'preco_voo.integer' => 'O campo preco_voo tem que ser um inteiro',
            'preco_voo.between' => 'O campo preco_voo tem que ser entre 0 e 99999.99',
            'modo_pagamento.required' => 'O campo modo_pagamento é requerido',
            'num_recibo.required' => 'O campo num_recibo é requerido',
            'num_licenca_piloto.required' => 'O campo num_licenca_piloto é requerido',
            'tipo_licenca_piloto.required' => 'O campo tipo_licenca_piloto é requerido',
            'validade_licenca_piloto.required' => 'O campo validade_licenca_piloto é requerido',
            'validade_licenca_piloto.after' => 'O campo validade_licenca_piloto é invalido (after)',
            'num_certificado_piloto.required' => 'O campo num_certificado_piloto é requerido',
            'classe_certificado_piloto.required' => 'O campo classe_certificado_piloto é requerido',
            'validade_certificado_piloto.required' => 'O campo validade_certificado_piloto é requerido',
            'validade_certificado_piloto.after' => 'O campo validade_certificado_piloto é invalido (after)',
            'confirmado.required' => 'O campo confirmado é requerido',
            'validade_certificado_instrutor.after' => 'O campo validade_certificado_instrutor é invalido (after)',
            'validade_licenca_instrutor.after' => 'O campo validade_licenca_instrutor é invalido (after)',
        ];
    }
}
