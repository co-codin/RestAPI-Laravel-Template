<?php

namespace Modules\Search\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        $this->mapApiRoutes();
    }

    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->group(module_path('Search', '/Routes/api.php'));
    }
}
