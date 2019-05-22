<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Aeronave extends Model
{
    protected $primaryKey = 'matricula';
    public $incrementing = false;
    
    protected $fillable = [
        'matricula', 'marca', 'modelo', 'num_lugares', 'conta_horas', 'preco_hora'
    ];

    public function movimentos()
    {
        return $this->hasMany(Movimento::class);
    }
}
