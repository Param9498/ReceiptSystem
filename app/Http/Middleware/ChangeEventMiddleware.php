<?php

namespace App\Http\Middleware;

use Closure;

class ChangeEventMiddleware
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
        if(!session('eventSelectedByUserForReceipt'))
        {
            return redirect()->route('changeEvent');
        }
        return $next($request);
    }
}
