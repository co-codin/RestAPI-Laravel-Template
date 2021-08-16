<?php


namespace Modules\Export\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ExportRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(['id', 'name', 'type', 'filename', 'frequency', 'created_at', 'updated_at'])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('type'),
                AllowedFilter::exact('filename'),
                AllowedFilter::exact('frequency'),
            ])
            ->allowedSorts('id', 'name', 'type', 'filename', 'frequency', 'created_at', 'updated_at')
            ;
    }
}