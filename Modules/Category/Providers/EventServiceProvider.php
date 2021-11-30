<?php

namespace Modules\Category\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Category\Events\CategorySaved;
use Modules\Category\Listeners\ReindexCategory;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CategorySaved::class => [
            ReindexCategory::class,
        ],
    ];
}
