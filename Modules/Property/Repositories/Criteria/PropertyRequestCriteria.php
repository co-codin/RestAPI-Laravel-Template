<?php


namespace Modules\Property\Repositories\Criteria;


use Modules\Category\Repositories\Criteria\CategoryRequestCriteria;
use Modules\Filter\Repositories\Criteria\FilterRequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class PropertyRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(array_merge(
                static::allowedPropertyFields(),
                FilterRequestCriteria::allowedFilterFields('filters')
            ))
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('description'),
                AllowedFilter::exact('is_hidden_from_product'),
                AllowedFilter::exact('is_hidden_from_comparison'),
            ])
            ->allowedIncludes(['filters'])
            ->allowedSorts(['name', 'key', 'created_at'])
            ;
    }

    public static function allowedPropertyFields($prefix = null): array
    {
        $fields = [
            'id',
            'name',
            'key',
            'description',
            'options',
            'is_hidden_from_product',
            'is_hidden_from_comparison',
            'created_at',
            'updated_at'
        ];

        if(!$prefix) {
            return $fields;
        }

        return array_map(fn($field) => $prefix . "." . $field, $fields);
    }
}
