<?php

namespace Modules\Brand\Services;

use Illuminate\Database\Eloquent\Builder;


class BrandBuilder
{
    public function getByCategories(Builder $builder, array $categoryIds): Builder
    {

        return $builder
            ->select(\DB::raw(1))
            ->from('products as p')
            ->join('product_category as pc', 'pc.product_id', '=', 'p.id')
            ->whereIn('pc.category_id', $categoryIds)
            ->whereRaw('p.brand_id = brands.id');

    }
}
