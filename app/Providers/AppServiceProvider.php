<?php

namespace App\Providers;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Google_Service_Drive;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(MacrosServiceProvider::class);

        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('elasticsearch.hosts'))
                ->build();
        });

        $this->app->bind(Google_Service_Drive::class, function ($app) {
            $client = new \Google_Client();
            $client->setClientId(config('services.google-api.client_id'));
            $client->setClientSecret(config('services.google-api.client_secret'));
            $client->refreshToken(config('services.google-api.refresh_token'));

            return new Google_Service_Drive($client);
        });
    }

    public function boot(): void
    {

    }
}
