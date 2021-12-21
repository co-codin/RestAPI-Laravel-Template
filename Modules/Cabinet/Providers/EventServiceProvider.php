<?php

namespace Modules\Cabinet\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Cabinet\Events\CabinetViewed;
use Modules\Cabinet\Listeners\UpdateView;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CabinetViewed::class => [
            UpdateView::class,
        ],
    ];
}
