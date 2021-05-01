<?php

namespace Modules\Product\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapApiRoutes();

        $this->mapAdminRoutes();
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('admin')
            ->as('admin.')
            ->prefix('admin')
            ->group(module_path('Product', '/Routes/admin.php'));
    }

    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->group(module_path('Product', '/Routes/api.php'));
    }
}
