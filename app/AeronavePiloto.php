<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AeronavePiloto extends Model
{
    protected $table = "aeronaves_pilotos";
    
    protected $fillable = [
        'matricula', 'piloto_id'
    ];

    
   	public function user()
	{
	  return $this->belongsTo('App\User', 'piloto_id');
	}
}
