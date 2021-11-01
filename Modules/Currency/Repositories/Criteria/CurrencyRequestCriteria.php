<?php


namespace Modules\Currency\Repositories\Criteria;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CurrencyRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(['id', 'name', 'iso_code', 'rate', 'is_main', 'created_at', 'updated_at', 'deleted_at'])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('iso_code'),
                AllowedFilter::exact('rate'),
                AllowedFilter::exact('is_main'),
                AllowedFilter::trashed(),
            ])
            ->allowedSorts('id', 'name', 'code', 'rate', 'is_main', 'created_at', 'updated_at', 'deleted_at')
            ;
    }
}
