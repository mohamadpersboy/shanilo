<?php

namespace App\Providers;

use App\Http\Helpers\Favorite\Favorite;
use Illuminate\Support\ServiceProvider;

class FavoriteServiceProvider extends ServiceProvider
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
        $this->app->singleton('favorite',function (){
            return new Favorite(\Cookie::get('favorite'));
        });
    }
}
