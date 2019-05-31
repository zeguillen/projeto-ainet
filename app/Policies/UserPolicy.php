<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability){
        if  ($user->direcao){
            return true;
        }
    }

    public function create(User $user)
    {
        return false;
    }

    public function view(User $user, User $model){
        return ($user->id == $model->id);
    }

    public function updateAll(User $user)
    {
        return false;
    }

    public function update(User $user, User $model)
    {
        if ($user->id==$model->id) {
            return true;
        }
        return false;
    }

    public function updatePiloto(User $user, User $model)
    {
        if ($user->id==$model->id && $user->tipo_socio == 'P') {
            return true;
        }
        return false;
    }

    public function viewPiloto(User $user)
    {
        return $user->tipo_socio == 'P';
    }

    public function delete(User $user)
    {
        return false;
    }

    public function acessoPendentes(User $user) 
    {
        return false;
    }
}