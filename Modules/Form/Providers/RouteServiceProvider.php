<?php

namespace Modules\Form\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
//        $this->mapAdminRoutes();

        $this->mapApiRoutes();
    }

    protected function mapAdminRoutes()
    {
        Route::middleware('admin')
            ->as('admin.')
            ->prefix('admin')
            ->group(module_path('Form', '/Routes/admin.php'));
    }

    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->group(module_path('Form', '/Routes/api.php'));
    }
}
