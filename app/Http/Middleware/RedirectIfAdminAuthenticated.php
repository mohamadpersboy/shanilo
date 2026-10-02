<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $auth=Auth::guard('admins');
        if ($auth->check() && Auth::guard('admins')->user()->status == 1 && Auth::guard('admins')->user()->role_id < 3) {
            return redirect('/'.env('ADMIN_ROUTE'));
        }
        return $next($request);
    }
}
