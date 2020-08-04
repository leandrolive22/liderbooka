<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Chat
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
        if( in_array(6,$permissions) || in_array(7,$permissions) || in_array(8,$permissions) || in_array(9,$permissions) || in_array(10,$permissions) || in_array(11,$permissions) ||  in_array(1, $permissions)) {
            return $next($request);
        }

        return back()->with('errorAlert','Você não tem permissão para acessar essa página');
    }
}
