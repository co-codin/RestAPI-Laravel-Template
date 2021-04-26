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
            ->allowedFields(['id', 'source', 'destination', 'code', 'created_at', 'updated_at'])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('source'),
                AllowedFilter::exact('destination'),
                AllowedFilter::exact('code'),
            ])
            ->allowedSorts('id', 'source', 'destination', 'code', 'created_at', 'updated_at')
            ;
    }
}
