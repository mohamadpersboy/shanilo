<?php

namespace App\Http\Middleware\Front;

use Closure;

class CheckOrderStatus
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
        $order = $request->route()->parameters['order'];

        if ($order->payment->status != 'successful')
            return response()->json(['errors' => ['message' => ['برای این سفارش پرداختی انجام نشده است ']]], 422);

        return $next($request);
    }
}
