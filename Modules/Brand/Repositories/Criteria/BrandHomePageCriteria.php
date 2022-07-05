<?php

namespace Modules\Brand\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class BrandHomePageCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->select('id', 'name', 'slug')
            ->withCount('products AS productCount')
            ;
    }
}
