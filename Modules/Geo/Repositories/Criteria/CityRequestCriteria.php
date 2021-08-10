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
                'id', 'region_name', 'region_name_with_type', 'federal_district', 'iso',
                'city_name', 'city_slug', 'status', 'is_default', 'coordinate', 'dial_code',
                'postal_index', 'region_phone', 'email', 'created_at', 'updated_at'
            ])
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('region_name'),
                AllowedFilter::partial('region_name_with_type'),
                AllowedFilter::partial('federal_district'),
                AllowedFilter::partial('city_name'),
                AllowedFilter::partial('city_slug'),
            ])
            ->allowedSorts('id', 'region_name', 'region_name_with_type', 'federal_district', 'iso',
                'city_name', 'city_slug', 'status', 'is_default', 'dial_code',
                'postal_index', 'region_phone', 'email', 'created_at', 'updated_at');
    }
}
