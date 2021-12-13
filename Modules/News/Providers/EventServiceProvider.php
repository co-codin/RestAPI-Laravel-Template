<?php

namespace Modules\News\Providers;

use Illuminate\Support\ServiceProvider;
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
