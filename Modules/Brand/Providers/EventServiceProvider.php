<?php

namespace Modules\Brand\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Brand\Events\BrandSaved;
use Modules\Brand\Listeners\ReindexBrand;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        BrandSaved::class => [
            ReindexBrand::class,
        ],
    ];
}
