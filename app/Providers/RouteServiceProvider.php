<?php

namespace App\Providers;

use App\Models\Specific\ArtistNews;
use function foo\func;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();

    }


    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map(Request $request)
    {

        $this->mapApiRoutes();

        $this->mapWebRoutes();

    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        //Admin
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin/base.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin/specific.php'));

        //Front
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/front/base.php'));
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/front/specific.php'));

        //front route
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/front.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
