<?php

namespace App\Http\Middleware;

use Auth;
use \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Closure;

class UserAtivo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->ativo == 1){
            return $next($request);
        }
        throw new AccessDeniedHttpException('Unauthorized.');
    }
}
