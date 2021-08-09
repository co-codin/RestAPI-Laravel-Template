<?php

namespace Modules\Geo\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class OrderPointRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields([
                'id', 'city_id', 'name', 'address', 'coordinate', 'embed_map_url', 'phone', 'email',
                'info', 'timetable', 'type', 'status', 'created_at', 'updated_at',
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('address'),
                AllowedFilter::exact('city_id'),
            ])
            ->allowedSorts('id', 'city_id', 'name', 'address', 'type', 'status', 'created_at', 'updated_at')
            ;
    }
}
