<?php

namespace Modules\Activity\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        $this->mapAdminRoutes();
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('auth:sanctum')
            ->as('admin.')
            ->prefix('admin')
            ->group(module_path('Activity', '/Routes/admin.php'));
    }
}
