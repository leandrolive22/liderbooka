<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class ManagerUsers
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
        if(in_array(34,$permissions) || in_array(35,$permissions) || in_array(36,$permissions) || in_array(37,$permissions) || in_array(45,$permissions) || in_array(1, $permissions)) {

            return $next($request);
        }

        return back()->with('errorAlert','Você não tem permissão para acessar essa página');
    }
}
