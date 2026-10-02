<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GateProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        \Gate::define('edit-product-owner', function ($user, $product) {
            $shops = $user->shops()->pluck('id')->toArray();
            return in_array($product->shop->id, $shops);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
