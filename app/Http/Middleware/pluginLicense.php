<?php

namespace App\Http\Middleware;

use Closure;

class pluginLicense
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next ,$action )
    {
        if ($action=='products')
            return redirect('/');
        else
            return $next($request);
    }
}
