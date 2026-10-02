<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfAdminAuthenticated
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
        if (\Session::get('lang') != null){
            \App::setLocale(\Session::get('lang'));
        }
        $auth=Auth::guard('admins');
        if (!$auth->check()) {
            return redirect('/'.env('ADMIN_ROUTE').'/login');
        } else {
            if($auth->user()->status == 0){
                $auth->logout();
                return redirect('/'.env('ADMIN_ROUTE').'/login')->with('err', __('messages.blocked_admin_user'));
            }
            if($auth->user()->role_id == 3){
                $auth->logout();
                return redirect()->route('front.home.index');
            }
        }

        return $next($request);
    }
}
