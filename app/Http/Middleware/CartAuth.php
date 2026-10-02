<?php

namespace App\Http\Middleware;

use App\Models\Specific\Cart;
use Closure;

class CartAuth
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
        if(!Cart::count()){
            return redirect()->route('front.cart.cart1');
        }
        return $next($request);
    }
}
