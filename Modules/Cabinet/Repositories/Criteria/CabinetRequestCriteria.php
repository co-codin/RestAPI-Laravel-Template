<?php

namespace Modules\Cabinet\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CabinetRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields([
                'id', 'name', 'image', 'slug',
                'image', 'full_description', 'status',
                'category_id', 'created_at', 'updated_at', 'deleted_at'
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('slug'),
                AllowedFilter::exact('category_id'),
                AllowedFilter::exact('status'),
            ])
            ->allowedSorts('id', 'name', 'slug', 'status', 'category_id', 'created_at', 'updated_at', 'deleted_at')
            ->allowedIncludes(['category'])
            ;
    }
}
