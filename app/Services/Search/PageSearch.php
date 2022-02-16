<?php

namespace App\Services\Search;

use App\Services\Interfaces\SearchInterface;
use Modules\Page\Models\Page;

class PageSearch implements SearchInterface
{
    protected $model = Page::class;

    public function search($query, array $mapping)
    {
        // query builder ! builder !
    }
}
