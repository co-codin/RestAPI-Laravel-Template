<?php

namespace Modules\Banner\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapAdminRoutes();
    }

    protected function mapApiRoutes()
    {
        Route::middleware('auth:sanctum')
            ->as('admin.')
            ->prefix('admin')
            ->group(module_path('Banner', '/Routes/admin.php'));
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('api')
            ->group(module_path('Banner', '/Routes/api.php'));
    }
}
