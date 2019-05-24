<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aerodromo extends Model
{
    protected $primaryKey = 'code';

    protected $fillable = [
        'nome', 'militar', 'ultraleve' 
    ];

    public function movimento(){
        return $this->hasMany('App\Movimento');
    }
}
