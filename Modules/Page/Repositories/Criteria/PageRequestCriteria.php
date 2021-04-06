<?php


namespace Modules\Page\Repositories\Criteria;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PageRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields([
                'id', 'name', 'slug', 'full_description', 'status', 'parent_id',
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('slug'),
                AllowedFilter::partial('full_description'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('parent_id'),
                AllowedFilter::trashed(),
            ])
            ->allowedIncludes(['seo', 'parent', 'children'])
            ->allowedSorts([
                'id', 'name', 'slug', 'full_description', 'status', 'parent_id',
            ]);
    }
}
