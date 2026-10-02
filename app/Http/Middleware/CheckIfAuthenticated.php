<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Front\Auth\RegisterController;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $auth = Auth::guard();
        if (!$auth->check()) {
           setSession([
               'header' => 'نیاز به ورود',
               'type' => 'warning',
               'message' => 'قبل از دسترسی به این صفحه لطفا ورود نمایید.'
           ], 'notification');
           return redirect()->route('front.home.index');
        }elseif ($auth->user()->confirm==0){
            sendConfirmationSMS(Auth::user());
            return redirect()->route('front.auth.register.mobile');
        }
        return $next($request);
    }
}
