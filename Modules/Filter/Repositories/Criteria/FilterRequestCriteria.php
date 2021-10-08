<?php


namespace Modules\Filter\Repositories\Criteria;


use Modules\Category\Repositories\Criteria\CategoryRequestCriteria;
use Modules\Property\Repositories\Criteria\PropertyRequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class FilterRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(array_merge(
                self::allowedFilterFields(),
                CategoryRequestCriteria::allowedCategoryFields('category'),
                PropertyRequestCriteria::allowedPropertyFields('property'),
            ))
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::exact('type'),
                AllowedFilter::exact('slug'),
                AllowedFilter::exact('category_id'),
                AllowedFilter::partial('description'),
                AllowedFilter::exact('is_enabled'),
                AllowedFilter::exact('is_default'),
                AllowedFilter::exact('property_id'),
                AllowedFilter::exact('options->field'),
            ])
            ->allowedIncludes('category', 'property')
            ->allowedSorts('name', 'slug', 'id', 'position', 'created_at', 'updated_at')
            ;
    }

    public static function allowedFilterFields($prefix = null): array
    {
        $fields = [
            'id', 'name', 'type', 'slug', 'category_id', 'description', 'facet',
            'is_enabled', 'is_default', 'property_id', 'options'
        ];

        if(!$prefix) {
            return $fields;
        }

        return array_map(fn($field) => $prefix . "." . $field, $fields);
    }
}
