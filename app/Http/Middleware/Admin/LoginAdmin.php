<?php

namespace App\Http\Middleware\Admin;

use Closure;

class LoginAdmin
{
    /**
     * Handle an incoming request.
     *
     * @author Reza Sarlak
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::guard('admins')->check() && \Auth::guard('admins')->user()->role_id) {
            $id = (\Auth::guard('admins')->user()->id);

            auth()->loginUsingId($id);
        }
        return $next($request);
    }
}
