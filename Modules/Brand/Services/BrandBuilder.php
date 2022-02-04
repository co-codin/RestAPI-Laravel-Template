<?php

namespace Modules\Brand\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;


class BrandBuilder
{
    public function getByCategories(Builder $builder, array $categoryIds): Builder
    {
        return $builder
            ->whereExists(function (\Illuminate\Database\Query\Builder $query) use ($categoryIds) {
                $query->select(DB::raw(1))
                    ->from('product_category as pc')
                    ->leftJoin('products as p', 'pc.product_id', '=', 'p.id')
                    ->leftJoin('brands as b', 'p.brand_id', '=', 'b.id')
                    ->whereIn('pc.category_id', $categoryIds)
                    ;

//
//                    $query
//                        ->select(\DB::raw(1))
//                        ->from('products as p')
//                        ->join('product_category as pc', 'pc.product_id', '=', 'p.id')
//                        ->join('categories as c', 'c.parent_id', '=', 'pc.category_id')
//                        ->whereIn('pc.category_id', $categoryIds)
//                        ->whereRaw('p.brand_id = brands.id');
            });
    }
}
