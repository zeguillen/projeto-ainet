<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Movimento extends Model
{
    protected $fillable = [
        'aeronave', 'data', 'hora_descolagem', 'hora_aterragem', 'tempo_voo', 'natureza', 'piloto_id', 'aerodromo_partida', 'aerodromo_chegada', 'num_aterragens',
        'num_descolagens', 'num_diario', 'num_servico', 'conta_horas_inicio', 'conta_horas_fim', 'num_pessoas', 'tipo_instrucao', 'instrutor_id', 'confirmado',
        'observacoes'
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

    public function user()
	{
	  return $this->belongsTo('App\User', 'piloto_id');
	}

}
