<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class Measures
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
        if(in_array(13, $permissions) || in_array(14, $permissions) || in_array(15, $permissions) || in_array(1, $permissions)) {
            return $next($request);
        }

        return back()->with('errorAlert','Você não tem permissão para acessar essa página');
    }
}
