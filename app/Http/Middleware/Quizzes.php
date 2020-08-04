<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Quizzes
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
        if( in_array(31,$permissions) || in_array(32,$permissions) || in_array(33,$permissions) || in_array(46,$permissions) ||  in_array(1, $permissions)) {
            return $next($request);
        }

        return back()->with('errorAlert','Você não tem permissão para acessar essa página');
    }
}
