<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Movimento extends Model
{

    protected $fillable = [
        'data', 'hora_descolagem', 'hora_aterragem', 'aeronave', 'num_diario', 'num_servico', 'piloto_id', 'natureza', 'aerodromo_partida', 'aerodromo_chegada', 'num_aterragens', 'num_descolagens', 'num_pessoas', 'conta_horas_inicio', 'conta_horas_fim', 'tempo_voo', 'preco_voo', 'modo_pagamento', 'num_recibo', 'observacoes', 'tipo_instrucao', 'num_licenca_piloto', 'tipo_licenca_piloto', 'validade_licenca_piloto', 'num_certificado_piloto', 'classe_certificado_piloto', 'validade_certificado_piloto', 'instrutor_id', 'tipo_licenca_instrutor', 'validade_licenca_instrutor', 'num_certificado_instrutor', 'classe_certificado_instrutor', 'validade_certificado_instrutor', 'confirmado', 'tipo_conflito', 'justificacao_conflito'
    ];

    public function naturezaToStr()
    {
        switch ($this->natureza) {
            case 'T':
                return 'Treino';
            case 'I':
                return 'Instrução';
            case 'E':
                return 'Especial';
        }

        return 'Unknown';
    }

    public function pagamentoToStr(){
        switch ($this->modo_pagamento){
            case 'N':
                return 'Numerário';
            case 'M':
                return 'Multibanco';
            case 'T':
                return 'Transferência';
            case 'P':
                return 'Pacote de horas';
        }

        return unknown;
    }

    public function tipoInstrucaoToStr(){
        switch ($this->tipo_instrucao){
            case 'D':
                return 'Duplo Comando';
            case 'S':
                return 'Solo';
        }

        return 'Nenhuma';
    }

    public function aeronavePiloto()
	{
	  return $this->belongsTo('App\User', 'piloto_id', 'id');
    }

    public function aeronaveInstrutor()
	{
	  return $this->belongsTo('App\User', 'instrutor_id', 'id');
    }

    public function aerodromoPartida(){
        return $this->belongsTo('App\Aerodromo', 'aerodromo_partida', 'code');
    }

    public function aerodromoChegada(){
        return $this->belongsTo('App\Aerodromo', 'aerodromo_chegada', 'code');
    }

    public function aeronaveMatricula(){
        return $this->belongsTo('App\Aeronave');
    }
}
