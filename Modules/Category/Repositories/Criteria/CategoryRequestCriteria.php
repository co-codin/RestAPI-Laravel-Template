<?php

namespace Modules\Category\Repositories\Criteria;

use App\Http\Filters\LiveFilter;
use Modules\Filter\Repositories\Criteria\FilterRequestCriteria;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(array_merge(
                self::allowedCategoryFields(),
                self::allowedCategoryFields('descendants'),
                self::allowedCategoryFields('ancestors'),
                self::allowedCategoryFields('parent'),
                self::allowedCategoryFields('children'),
                FilterRequestCriteria::allowedFilterFields('filters'),
            ))
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('slug'),
                AllowedFilter::partial('product_name'),
                AllowedFilter::partial('full_description'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('is_in_home'),
                AllowedFilter::exact('is_hidden_in_parents'),
                AllowedFilter::exact('image'),
                AllowedFilter::exact('parent_id'),
                AllowedFilter::scope('is_root'),
                AllowedFilter::custom('live', new LiveFilter([
                    'id' => '=',
                    'name' => 'like',
                    'slug' => 'like',
                ])),
                AllowedFilter::trashed(),
            ])
            ->allowedIncludes([
                'parent',
                'ancestors',
                'descendants',
                'children',
                'seo',
                'filters',
                AllowedInclude::count('productsCount'),
            ])
            ->allowedSorts([
                'id', 'name', 'slug', 'product_name', '_lft', 'created_at', 'updated_at', 'deleted_at',
            ]);
    }

    public static function allowedCategoryFields($prefix = null): array
    {
        $fields = [
            'id', 'name', 'slug', 'product_name', 'full_description', 'image', '_lft', '_rgt',
            'status', 'is_hidden_in_parents', 'is_in_home', 'parent_id',
            'created_at', 'updated_at', 'deleted_at',
        ];

        if(!$prefix) {
            return $fields;
        }

        return array_map(fn($field) => $prefix . "." . $field, $fields);
    }
}
