<?php

namespace App\Http\Middleware\Front;

use Closure;

class LoginFront
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

//        if (session()->has('front-login')){
//            auth()->logout();
//            auth()->login(session('front-login'));
//        }
//

        return $next($request);
    }
}
