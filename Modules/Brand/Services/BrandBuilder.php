<?php

namespace Modules\Brand\Services;

use Illuminate\Database\Eloquent\Builder;


class BrandBuilder
{
    public function getByCategories(Builder $builder, array $categoryIds): Builder
    {
        return $builder->joinSub(function (\Illuminate\Database\Query\Builder $query) use ($categoryIds) {
            $query
                ->select('p.brand_id')
                ->from('products as p')
                ->join('product_category as pc', 'pc.product_id', '=', 'p.id')
                ->whereIn('pc.category_id', $categoryIds)
                ->groupBy('p.brand_id');
        }, 'grouped_brands', 'grouped_brands.brand_id', '=', 'brands.id')
            ->where('brands.status', true)
            ->whereNull('brands.deleted_at');
    }
}
