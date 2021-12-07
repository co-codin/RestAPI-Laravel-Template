<?php

namespace Modules\Review\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\Review\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapApiRoutes();

        $this->mapAdminRoutes();
    }

    /**
     * Define the "admin" routes for the application.
     */
    protected function mapAdminRoutes(): void
    {
        Route::middleware('admin')
            ->as('admin.')
            ->prefix('admin')
            ->group(module_path('Review', '/Routes/admin.php'));
    }

    /**
     * Define the "api" routes for the application.
     */
    protected function mapApiRoutes(): void
    {
        Route::middleware('api')
            ->group(module_path('Review', '/Routes/api.php'));
    }
}
