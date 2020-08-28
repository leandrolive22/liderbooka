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
        @Storage::put('sys_logs'.DIRECTORY_SEPARATOR.date('ymdh').'txt',json_encode($request));
        return $next($request);
    }
}
