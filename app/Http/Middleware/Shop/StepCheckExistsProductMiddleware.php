<?php

namespace App\Http\Middleware\Shop;

use Closure;
use App\Http\Helpers\Cart\Facade\Cart;

class StepCheckExistsProductMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        foreach (Cart::details() as $index => $cartDetail) {
            foreach ($cartDetail->details as $index => $cartDetailProduct) {

                if ($cartDetailProduct->productDetail->count <= 0)
                    Cart::remove($cartDetailProduct->productDetail);
            }
        }

        return $next($request);
    }
}
