<?php

namespace Modules\News\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class NewsHomePageCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->select('id', 'short_description', 'name', 'slug', 'image', 'published_at', 'view_num');
    }
}
