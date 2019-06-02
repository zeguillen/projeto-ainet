<?php

namespace App\Policies;

use App\User;
use App\Aeronave;
use Illuminate\Auth\Access\HandlesAuthorization;

class AeronavePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability){
        if  ($user->direcao){
            return true;
        }
    }

    public function view(User $user){
        return false;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user)
    {
        return false;
    }

    public function delete(User $user)
    {
        return false;
    }
}
