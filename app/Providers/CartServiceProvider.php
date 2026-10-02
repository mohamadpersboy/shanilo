<?php

namespace App\Providers;

use App\Http\Helpers\Cart\Cart;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('cart', function () {
            return new Cart(\Cookie::get('cart'));
        });
    }
}
