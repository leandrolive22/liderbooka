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
        $result = 0;
        $permissions_ids = [19,20,21,22,23,24,25,47,50,51,52,53,54,55,61,64,65,66,67,68];
        foreach($permissions as $item) {
            if(in_array($item,$permissions_ids)) {
                $result++;
            }
        }


        if($result > 0) {
            return $next($request);
        }

        return back()->with('errorAlert','Você não tem permissão para acessar essa página');
    }
}
