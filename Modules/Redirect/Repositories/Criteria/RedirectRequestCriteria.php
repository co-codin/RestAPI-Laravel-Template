<?php


namespace Modules\Redirect\Repositories\Criteria;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RedirectRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('position')
            ->allowedFields(['id', 'name', 'image', 'position', 'is_enabled', 'created_at', 'updated_at'])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('image'),
                AllowedFilter::exact('is_enabled'),
            ])
            ->allowedSorts('id', 'name', 'image', 'position', 'is_enabled', 'created_at', 'updated_at')
            ;
    }
}
