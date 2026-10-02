<?php

namespace App\Http\Middleware\Front;

use App\Models\ShortLink;
use Closure;

class BindShortLink
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
        $check = explode('@', $request->path());

        if (is_array($check) && isset($check[1]) && is_numeric($check[1])) {

            $url = ShortLink::find($check[1]);

            return redirect()->to($url->link);

        }

        return $next($request);
    }
}
