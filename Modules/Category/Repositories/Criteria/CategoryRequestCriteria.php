<?php

namespace Modules\Category\Repositories\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryRequestCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return QueryBuilder::for($model)
            ->defaultSort('-id')
            ->allowedFields(array_merge(
                $this->allowedCategoryFields(),
                $this->allowedCategoryFields('descendants'),
                $this->allowedCategoryFields('ancestors'),
                $this->allowedCategoryFields('parent'),
            ))
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('slug'),
                AllowedFilter::partial('product_name'),
                AllowedFilter::partial('full_description'),
                AllowedFilter::partial('short_properties'),
                AllowedFilter::exact('status'),
                AllowedFilter::exact('is_in_home'),
                AllowedFilter::exact('is_hidden_in_parents'),
                AllowedFilter::exact('image'),
                AllowedFilter::exact('parent_id'),
                AllowedFilter::trashed(),
            ])
            ->allowedIncludes(['parent', 'ancestors', 'descendants'])
            ->allowedSorts([
                'id', 'name', 'slug', 'product_name', '_lft', 'created_at', 'updated_at', 'deleted_at',
            ])
            ;
    }

    protected function allowedCategoryFields($prefix = null): array
    {
        $fields = [
            'id', 'name', 'slug', 'product_name', 'full_description', 'image', '_lft', '_rgt',
            'status', 'is_hidden_in_parents', 'is_in_home', 'parent_id', 'short_properties',
            'created_at', 'updated_at', 'deleted_at',
        ];

        if(!$prefix) {
            return $fields;
        }

        return array_map(fn($field) => $prefix . "." . $field, $fields);
    }
}
