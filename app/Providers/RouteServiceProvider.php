<?php

namespace App\Providers;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
class RouteServiceProvider extends ServiceProvider
{
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
    public function map()
    {
        $this->mapFrontendRoutes();
        $this->mapBackendRoutes();
        //
    }
    /**
     * Define the "backend" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapBackendRoutes()
    {
        Route::prefix('backend')->namespace('App\Http\Controllers\Backend')->group(base_path('routes/backend.php'));
    }
    /**
     * Define the "frontend" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapFrontendRoutes()
    {
        Route::prefix('frontend')->namespace('App\Http\Controllers\Frontend')->group(base_path('routes/frontend.php'));
    }
}
