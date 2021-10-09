<?php

namespace Modules\Category\Services;

use Illuminate\Database\Eloquent\Builder;
use Modules\Category\Models\Category;


class CategoryBuilder
{
    public function getRootCategories(Builder $builder, array $productIds)
    {
        dd(
            $builder->first()->toArray()
        );
//        $parentCategories = Category::query()->whereHas(
//            'productCategories',
//            fn($builder) => $builder->whereIn('product_id', $productIds)
//        )->with(['parent'])->get()->pluck('parent');
//
//        $parentCategories->each(function(Category $parentCategory) use ($productIds) {
//            $parentCategory->descendants()->each(function (Category $category) use ($productIds, $parentCategory) {
//                $count = $category->productCategories()->whereIn('product_id', $productIds)->count();
//                $parentCategory->product_count += $count;
//            });
//            $parentCategory->product_count += $parentCategory->productCategories()->whereIn('product_id', $productIds)->count();
//        });
//
//        return $parentCategories;
    }
}
