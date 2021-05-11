<?php

namespace Modules\Seo\Facades;

use Illuminate\Support\Facades\Facade;

class Canonical extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CanonicalManager::class;
    }
}
