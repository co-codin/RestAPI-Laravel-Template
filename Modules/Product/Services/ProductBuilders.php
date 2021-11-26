<?php


namespace Modules\Product\Services;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Category\Models\Category;

class ProductBuilders
{
    const COVID_PROPERTY_ID = 259;

    public function rootCategory(Builder $builder, int $rootCategory): Builder
    {
        $rootCategory = Category::findOrFail($rootCategory);

        $ids = $rootCategory->descendants()
            ->pluck('id')
            ->add($rootCategory->id);

        return $builder->whereHas(
            'productCategories',
            fn($builder) => $builder->whereIn('category_id', $ids)
        );
    }

    public function fromCovid(Builder $builder, bool $fromCovid): Builder
    {
        $method = $fromCovid ? "whereExists" : "whereNotExists";

        return $builder->{$method}(function($query) {
            $query->select(DB::raw(1))
                ->from('product_property as pp')
                ->whereColumn('pp.product_id', 'products.id')
                ->where('pp.property_id', static::COVID_PROPERTY_ID)
                ->whereJsonContains('pp.field_value_ids', 1);
        });
    }

    public function getStockProductsByCategories(Builder $builder, array $categoryIds): Builder
    {
        return $builder->whereExists(function (\Illuminate\Database\Query\Builder $builder) use ($categoryIds) {
            $builder
//                ->select(DB::raw(1))
//                ->from('product_category as pc')
//                ->join('products as p', 'pc.product_id', '=', 'p.id')
//                ->join('product_variations as pv', 'pv.product_id', '=', 'p.id')
//                ->whereIn('pc.category_id', $categoryIds)
//                ->whereNotNull('pv.previous_price')
//                ->where('pv.is_price_visible', true);
                ->select(DB::raw(1))
                ->from('products as p')
                ->join('product_category as pc', 'pc.product_id', '=', 'p.id')
                ->join('product_variations as pv', 'pv.product_id', '=', 'p.id')
                ->whereIn('pc.category_id', $categoryIds)
                ->whereNotNull('pv.previous_price')
                ->where('pv.is_price_visible', true)
                ->groupBy('pc.product_id');
        });
//                ->select('products.*')
//                ->join('product_category as pc', 'pc.product_id', '=', 'products.id')
//                ->join('product_variations as pv', 'pv.product_id', '=', 'products.id')
//                ->whereIn('pc.category_id', $categoryIds)
//                ->whereNotNull('pv.previous_price')
//                ->where('pv.is_price_visible', true);
    }
}
