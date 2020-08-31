<?php

namespace App\Http\Middleware;

use Closure;
use Storage;

class LogsRequest
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
        // if(Storage::disk('local')->exists('sys_logs'.DIRECTORY_SEPARATOR.date('ym').DIRECTORY_SEPARATOR.date('dh').'txt')) {
        //     Storage::append('sys_logs'.DIRECTORY_SEPARATOR.date('ym').DIRECTORY_SEPARATOR.date('dh').'txt',json_encode($request->request));
        // } else {
        //     Storage::put('sys_logs'.DIRECTORY_SEPARATOR.date('ym').DIRECTORY_SEPARATOR.date('dh').'txt',json_encode($request->request));
        // }
        
        return $next($request);
    }
}
