<?php


namespace Modules\Category\Repositories\Criteria;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class CategoryRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model::query())
            ->defaultSort('id')
            ->allowedFields(['id', 'name', 'slug', 'image', 'website', 'country', 'status', 'in_home', 'position'])
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
