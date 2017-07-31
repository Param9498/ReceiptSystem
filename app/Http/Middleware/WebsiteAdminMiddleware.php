<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class WebsiteAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $both = null)
    {
        //dd($both);
        $user = Auth::user();
        if ($both = 'both') {
            if($user->website_admin == 1 || isset($user->roles()->where('name', 'Organization Admin')->first()->id))
            {
                return $next($request);
            }
            else
            {
                return redirect('/');
            }
        }
        else {
            if($user->website_admin == 1)
            {
                return $next($request);
            }
            else
            {
                return redirect('/');
            }
        }
    }
}
