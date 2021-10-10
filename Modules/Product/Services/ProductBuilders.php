<?php


namespace Modules\Product\Services;


use Illuminate\Database\Eloquent\Builder;
use Modules\Category\Models\Category;

class ProductBuilders
{
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
}
