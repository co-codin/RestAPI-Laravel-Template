<?php


namespace Modules\Attribute\Repositories\Criteria;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AttributeRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('id')
            ->allowedFields(['id', 'name', 'is_default', 'created_at', 'updated_at', 'deleted_at'])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('is_default'),
                AllowedFilter::trashed(),
            ])
            ->allowedSorts('id', 'name', 'is_default', 'created_at', 'updated_at', 'deleted_at')
            ;
    }
}
