<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

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
    protected $namespaceAPI = 'App\Http\Controllers\API';
    protected $namespaceFrontend = 'App\Http\Controllers\Frontend';
    protected $namespaceBackend = 'App\Http\Controllers\Backend';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapWebFrontendRoutes();
        $this->mapWebBackendRoutes();
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
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "web frontend" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebFrontendRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespaceFrontend)
             ->group(base_path('routes/frontend.php'));
    }

    /**
     * Define the "web backend" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebBackendRoutes()
    {
        Route::middleware('auth')
             ->namespace($this->namespaceBackend)
             ->group(base_path('routes/backend.php'));
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
             ->namespace($this->namespaceAPI)
             ->group(base_path('routes/api.php'));
    }
}
