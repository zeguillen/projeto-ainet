<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'num_socio', 'nome_informal', 'name', 'sexo', 'data_nascimento', 'email', 'foto', 'nif', 'telefone', 
        'endereco', 'tipo_socio', 'quota_paga', 'ativo', 'password_inicial', 'password','direcao'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function typeToStr()
    {
        switch ($this->tipo_socio) {
            case 'P':
                return 'Piloto';
            case 'NP':
                return 'Não Piloto';
            case 'A':
                return 'Aeromodelista';
        }

        return 'Unknown';
    }

    public function sexToStr()
    {
        switch ($this->sexo) {
            case 'F':
                return 'Feminino';
            case 'M':
                return 'Masculino';
        }

        return 'Unknown';
    }



    public function movimento()
    {
        return $this->hasMany('App\Movimento');
    }

    // public function aeronavePiloto() 
    // {
    //     return $this->hasMany('App\AeronavePiloto');
    // }

    public function aeronaves(){
        return $this->belongsToMany('App\Aeronave', 'aeronaves_pilotos', 'piloto_id', 'matricula');
    }

}
