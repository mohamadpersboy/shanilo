<?php

namespace App\Providers;

use App\Http\Helpers\Comparison\Comparison;
use Illuminate\Support\ServiceProvider;

class ComparisonServiceProvider extends ServiceProvider
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
        $this->app->singleton('comparison',function (){
            return new Comparison(\Cookie::get('comparison'));
        });
    }
}
