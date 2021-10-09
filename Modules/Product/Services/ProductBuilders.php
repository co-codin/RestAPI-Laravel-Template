<?php


namespace Modules\Product\Services;


use Illuminate\Database\Eloquent\Builder;
use Modules\Category\Models\Category;

class ProductBuilders
{
    public function rootCategory(Builder $builder, int $rootCategory): Builder
    {
        $rootCategory = Category::findOrFail($rootCategory);

        return $builder->whereHas(
            'productCategories',
            fn($builder) => $builder->whereIn('category_id', $rootCategory->descendants()->pluck('id'))
        );
    }
}
