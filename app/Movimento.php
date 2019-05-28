<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Movimento extends Model
{

    protected $fillable = [
        'aeronave', 'data', 'hora_descolagem', 'hora_aterragem', 'tempo_voo', 'natureza', 'piloto_id', 'aerodromo_partida', 'aerodromo_chegada', 'num_aterragens', 'num_descolagens', 'num_diario', 'num_servico', 'conta_horas_inicio', 'conta_horas_fim', 'num_pessoas', 'tipo_instrucao', 'instrutor_id', 'observacoes', 'modo_pagamento', 'num_recibo'
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

    public function user()
	{
	  return $this->belongsTo('App\User', 'piloto_id');
    }
    
    public function aerodromoPartida(){
        return $this->belongsTo('App\Aerodromo', 'aerodromo_partida', 'code');
    }

    public function aerodromoChegada(){
        return $this->belongsTo('App\Aerodromo', 'aerodromo_chegada', 'code');
    }

    public function estadoMovimento(){

    }
}
