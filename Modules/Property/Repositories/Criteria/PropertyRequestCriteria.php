<?php


namespace Modules\Property\Repositories\Criteria;


use App\Http\Filters\LiveFilter;
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
                AllowedFilter::exact('key'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('description'),
                AllowedFilter::exact('is_hidden_from_product'),
                AllowedFilter::exact('is_hidden_from_comparison'),
                AllowedFilter::exact('is_boolean'),
                AllowedFilter::exact('is_numeric'),
                AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                    'name' => 'like',
                    'key' => 'like',
                ])),
            ])
            ->allowedIncludes(['filters'])
            ->allowedSorts(['id', 'name', 'key', 'created_at'])
            ;
    }

    public static function allowedPropertyFields($prefix = null): array
    {
        $fields = [
            'id',
            'name',
            'key',
            'unit',
            'description',
            'options',
            'is_hidden_from_product',
            'is_hidden_from_comparison',
            'is_in_variations',
            'is_boolean',
            'created_at',
            'updated_at'
        ];

        if(!$prefix) {
            return $fields;
        }

        return array_map(fn($field) => $prefix . "." . $field, $fields);
    }
}
