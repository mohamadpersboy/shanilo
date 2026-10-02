<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Front\Auth\RegisterController;
use Closure;

class CheckIfUserConfirmed
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
        if(\Auth::check()){
            if(\Auth::user()->confirm==0){
               sendConfirmationSMS(\Auth::user());
                return redirect()->route('front.auth.register.mobile');
            }
        }
        return $next($request);
    }
}
