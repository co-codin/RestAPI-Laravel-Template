<?php

namespace Modules\Product\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Product\Events\ProductSaved;
use Modules\Product\Listeners\ReindexProduct;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ProductSaved::class => [
            ReindexProduct::class,
        ],
    ];
}
