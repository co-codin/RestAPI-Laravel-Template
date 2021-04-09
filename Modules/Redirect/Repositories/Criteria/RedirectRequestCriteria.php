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
            ->defaultSort('-id')
            ->allowedFields(['id', 'old_url', 'new_url', 'code', 'created_at', 'updated_at'])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('old_url'),
                AllowedFilter::exact('new_url'),
                AllowedFilter::exact('code'),
            ])
            ->allowedSorts('id', 'old_url', 'new_url', 'code', 'created_at', 'updated_at')
            ;
    }
}
