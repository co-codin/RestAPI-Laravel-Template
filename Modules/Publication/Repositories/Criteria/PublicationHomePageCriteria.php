<?php

namespace Modules\Publication\Repositories\Criteria;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class PublicationHomePageCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->select('id', 'name', 'source', 'url', 'logo', 'published_at');
    }
}
