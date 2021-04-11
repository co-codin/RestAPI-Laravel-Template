<?php

namespace Modules\News\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapAdminRoutes();
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('admin')
            ->prefix('admin')
            ->as('admin.')
            ->group(module_path('News', '/Routes/admin.php'));
    }

    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->group(module_path('News', '/Routes/api.php'));
    }
}
