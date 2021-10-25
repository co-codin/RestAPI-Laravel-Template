<?php

namespace Modules\Brand\Repositories\Criteria;

use App\Filters\ToggleFilter;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BrandRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('id')
            ->allowedFields(array_merge(
                static::allowedBrandFields(),
            ))
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('slug'),
                AllowedFilter::exact('image'),
                AllowedFilter::partial('website'),
                AllowedFilter::exact('country_id'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('is_in_home'),
                AllowedFilter::exact('position'),
                AllowedFilter::custom('is_flagged', new ToggleFilter('brand')),
                AllowedFilter::trashed(),
            ])
            ->allowedIncludes(['seo', 'country'])
            ->allowedSorts([
                'id', 'created_at', 'deleted_at', 'updated_at', 'name', 'slug', 'image', 'website', 'status', 'in_home', 'position'
            ]);
    }

    public static function allowedBrandFields($prefix = null): array
    {
        $fields = [
            'id', 'name', 'full_description', 'full_description', 'slug', 'image', 'website', 'country', 'status', 'is_in_home', 'position', 'created_at', 'updated_at', 'deleted_at',
        ];

        if(!$prefix) {
            return $fields;
        }

        return array_map(fn($field) => $prefix . "." . $field, $fields);
    }
}
