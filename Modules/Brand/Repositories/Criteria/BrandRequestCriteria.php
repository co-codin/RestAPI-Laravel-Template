<?php

namespace Modules\Brand\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BrandRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model::query())
            ->defaultSort('id')
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('slug'),
                AllowedFilter::exact('image'),
                AllowedFilter::partial('website'),
                AllowedFilter::exact('country'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('is_in_home'),
                AllowedFilter::exact('position'),
            ])
            ->allowedSorts('id', 'name', 'slug', 'image', 'website', 'country', 'status', 'in_home', 'position')
            ;
    }
}
