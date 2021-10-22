<?php


namespace Modules\Geo\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CityRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields([
                'id', 'federal_district', 'region_id', 'name', 'slug', 'status', 'is_default',
                'coordinate', 'dial_code', 'postal_index', 'region_phone', 'email', 'created_at', 'updated_at',
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('federal_district'),
                AllowedFilter::exact('region_id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('status'),
                AllowedFilter::partial('slug'),
                AllowedFilter::exact('is_default'),
            ])
            ->allowedSorts('id', 'federal_district', 'region_id', 'name', 'slug', 'status', 'is_default', 'email', 'created_at', 'updated_at')
            ->allowedIncludes(['orderPoints', 'soldProducts'])
            ->withCount(['orderPoints', 'soldProducts'])
            ;
    }
}
