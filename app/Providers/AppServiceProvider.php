<?php

namespace App\Providers;

use App\Notifications\JobFailedNotification;
use Carbon\Carbon;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Google_Service_Drive;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Date\Date;

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
        $this->setLocale();
        $this->queueFailingNotification();
    }

    private function setLocale(): void
    {
        Date::setLocale(config('app.locale'));
        setlocale(LC_TIME, 'ru_RU.utf8');
        Carbon::setLocale(config('app.locale'));
    }

    private function queueFailingNotification(): void
    {
        \Queue::failing(function (JobFailed $event) {
            info("sending...");
            $notification = \Notification::route('mail', config('services.mails.exception'));

            if (!app()->environment('local')) {
                $notification->route('slack', config('logging.channels.slack.url'));
            }

            $notification->notify(new JobFailedNotification($event));
        });
    }
}
