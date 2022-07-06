<?php

namespace Modules\Cabinet\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class CabinetPageCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->select(
                'id', 'name', 'slug', 'image', 'welcome_text', 'full_description'
            )
            ->with(['categories' => function ($query) {
                $query->addSelect(
                    'id', 'categories.name', 'slug', 'image', 'status'
                );
            }])
            ->with(['seo' => function ($query) {
                $query->addSelect(
                    'seoable_id', 'title', 'description', 'h1', 'is_enabled'
                );
            }])
            ;
    }
}
