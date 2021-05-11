<?php

namespace Modules\Seo\Facades;

use Illuminate\Support\Facades\Facade;

class MetaTags extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MetaTagsManager::class;
    }
}
