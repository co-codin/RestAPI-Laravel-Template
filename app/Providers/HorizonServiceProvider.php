<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cookie;
use Laravel\Horizon\Horizon;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');
    }

    protected function gate()
    {
        Gate::define('viewHorizon', fn($user) => true);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Horizon::night();
    }
}
