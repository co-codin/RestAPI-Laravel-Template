<?php

namespace Modules\Geo\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SoldProductRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields([
                'id', 'title', 'product_id', 'city_id',
                'category_id', 'type', 'status',
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('title'),
                AllowedFilter::exact('product_id'),
                AllowedFilter::exact('city_id'),
                AllowedFilter::exact('category_id'),
                AllowedFilter::exact('type'),
                AllowedFilter::exact('status'),
            ])
            ->allowedSorts('id', 'title', 'product_id', 'city_id', 'category_id', 'type', 'status')
            ->allowedIncludes(['product', 'city', 'category']);
    }
}
