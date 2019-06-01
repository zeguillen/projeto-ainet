<?php

namespace App\Providers;

use App\User;
use App\Aeronave;
use App\Movimento;
use App\Policies\UserPolicy;
use App\Policies\AeronavePolicy;
use App\Policies\MovimentoPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Aeronave::class => AeronavePolicy::class,
        Movimento::class => MovimentoPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
