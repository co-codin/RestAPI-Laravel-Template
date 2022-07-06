<?php

namespace Modules\Brand\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class BrandPageCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->select(
                'id', 'name', 'slug', 'image', 'short_description', 'full_description'
            )
            ->with(['seo' => function ($query) {
                $query->addSelect('seoable_id', 'title', 'h1', 'description', 'is_enabled');
            }])
            ;
    }
}
