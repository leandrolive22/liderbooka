<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Monitoria
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
        $permissions = Session::get('permissionsIds');
        if( in_array(18,$permissions) || in_array(19,$permissions) || in_array(20,$permissions) || in_array(21,$permissions) || in_array(22,$permissions) || in_array(23,$permissions) || in_array(24,$permissions) || in_array(25,$permissions) || in_array(47,$permissions) || in_array(50,$permissions) || in_array(51,$permissions) || in_array(52,$permissions) || in_array(53,$permissions) || in_array(54,$permissions) || in_array(55,$permissions)  || in_array(1, $permissions)) {
            return $next($request);
        }

        return back()->with('errorAlert','Você não tem permissão para acessar essa página');
    }
}
