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

        return $builder->whereHas(
            'productCategories',
            fn($builder) => $builder->whereIn('category_id', $rootCategory->descendants()->pluck('id'))
        );
    }

    public function fromCovid(Builder $builder, bool $fromCovid): Builder
    {
        return $builder->whereExists(function($query) use ($fromCovid) {
            $query->select(DB::raw(1))
                ->from('product_property as pp')
                ->whereColumn('pp.product_id', 'products.id')
                ->where('pp.property_id', static::COVID_PROPERTY_ID)
                ->whereJsonContains('pp.value', true);
        });
    }
}
