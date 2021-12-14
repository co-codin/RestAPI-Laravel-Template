<?php

namespace Modules\News\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\News\Events\NewsViewed;
use Modules\News\Listeners\UpdateView;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NewsViewed::class => [
            UpdateView::class,
        ],
    ];
}
