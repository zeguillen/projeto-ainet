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
        if ($user->id==$model->id && $user->tipo_piloto == 'P') {
            return true;
        }
        return false;
    }

    public function delete(User $user)
    {
        return false;
    }
}