<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Wiki
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
        if(in_array(38,$permissions) || in_array(39,$permissions) || in_array(40,$permissions) || in_array(41,$permissions) || in_array(42,$permissions) || in_array(43,$permissions) || in_array(44,$permissions) || in_array(56,$permissions) ||   in_array(1, $permissions)) {

            return $next($request);
        }

        return back()->with('errorAlert','Você não tem permissão para acessar essa página');
    }
}
