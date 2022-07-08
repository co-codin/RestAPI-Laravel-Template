<?php

namespace Modules\Category\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class CategoryPageCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->select('id', 'name', 'slug', 'image', 'full_description', 'parent_id', '_lft', '_rgt')
            ->with([
                'ancestors' => function ($query) {
                    $query->addSelect('id', 'parent_id', 'name', 'slug', '_lft', '_rgt');
                }
            ])
            ->with([
                'descendants' => function ($query) {
                    $query->addSelect('id', 'parent_id', '_lft', '_rgt');
                }
            ])
            ->with([
                'children' => function ($query) {
                    $query->addSelect('id', 'name', 'slug', 'image', 'status', '_lft', 'parent_id', '_lft', '_rgt');
                }
            ])
            ->with(['seo' => function ($query) {
                $query->addSelect('seoable_id', 'title', 'description', 'h1', 'is_enabled');
            }])
            ->with([
                'filters' => function ($query) {
                    $query->with(['property' => function ($query) {
                        $query->addSelect('id', 'key');
                    }]);
                }
            ])
            ;
    }
}
