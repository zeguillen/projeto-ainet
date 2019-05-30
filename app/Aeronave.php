<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aeronave extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'matricula';
    public $incrementing = false;
    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'matricula', 'marca', 'modelo', 'num_lugares', 'conta_horas', 'preco_hora'
    ];

    public function movimentosAeronave(){
        return $this->hasMany('App\Movimento');
    }

    public function users(){
        return $this->belongsToMany('App\User', 'aeronaves_pilotos', 'matricula');
    }
}
