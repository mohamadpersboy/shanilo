<?php

namespace App\Http\Middleware\Shop;

use App\Http\Helpers\Cart\Facade\Cart;
use Closure;

class CartMiddleware
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
        $productDetail = ($request->route()->parameters['productDetail']);
        $checkExitCart = Cart::has($productDetail);
        if (!$checkExitCart && $productDetail->count <= 0 && $request->ajax())
            return response()->json(['status' => 403, 'message' => trans('messageShop.unavailable-product')]);


        return $next($request);
    }
}
