<?php

namespace App\Http\Middleware;

use Closure;

class ReceiptAdminPrivilegesMiddleware
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
        $event = \App\Event::where('id', session('eventSelectedByUserForReceipt'))->first();
        $privileged = $event->organization->receipts_handle_privileges;
        $privileged = json_decode($privileged);
        $user = \Auth::user();
        $user_privilege = $user->roles()->where('organization_id', $event->organization->id)->get();
        $privileges = [];
        foreach ($user_privilege as $userprivilege) {
            array_push($privileges, $userprivilege->privilege_level);
        }
        if (!empty(array_intersect($privileges, $privileged))) {
            return $next($request);
        }
        else
            return redirect()->route('newReceiptView');
    }
}
