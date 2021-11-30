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

        return $builder->{$method}(function ($query) {
            $query->select(DB::raw(1))
                ->from('product_property as pp')
                ->whereColumn('pp.product_id', 'products.id')
                ->where('pp.property_id', static::COVID_PROPERTY_ID)
                ->whereJsonContains('pp.field_value_ids', 1);
        });
    }

    public function getProductsByCategories(Builder $builder, array $categoryIds): Builder
    {
        return $builder->whereExists(function (\Illuminate\Database\Query\Builder $builder) use ($categoryIds) {
            $builder
                ->select(DB::raw(1))
                ->from('product_category as pc')
                ->join('product_variations as pv', 'pv.product_id', '=', 'products.id')
                ->whereRaw('pc.product_id = products.id')
                ->whereIn('pc.category_id', $categoryIds);
        });
    }

    public function getHotProducts(Builder $builder, bool $hot): Builder
    {
        return $builder->whereExists(function (\Illuminate\Database\Query\Builder $builder) use ($hot) {
            $builder
                ->select(DB::raw(1))
                ->from('product_variations as pv')
                ->whereRaw('pv.product_id = products.id');

            if ($hot) {
                $builder
                    ->whereNotNull('pv.previous_price')
                    ->where('pv.is_price_visible', true);
            } else {
                $builder
                    ->where('pv.is_price_visible', false)
                    ->orWhereNull('pv.previous_price');
            }
        });
    }
}
