<?php

namespace Modules\Contact\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ContactRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields([
                'id', 'first_name', 'last_name', 'job_position', 'email',
                'phone', 'image', 'position', 'is_enabled',
                'created_at', 'updated_at',
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('first_name'),
                AllowedFilter::partial('last_name'),
                AllowedFilter::exact('is_enabled'),
            ])
            ->allowedSorts('id', 'last_name', 'position', 'is_enabled', 'created_at', 'updated_at')
            ;
    }
}
