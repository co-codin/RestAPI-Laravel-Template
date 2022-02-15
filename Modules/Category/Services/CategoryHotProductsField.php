<?php


namespace Modules\Category\Services;


use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Category\Models\Category;
use Modules\Product\Models\Product;

class CategoryHotProductsField
{
    public function __invoke(Category $category)
    {
        return Product::query()
            ->whereExists(function (Builder $builder) use ($category) {
                $builder
                    ->select(DB::raw(1))
                    ->from('product_category as pc')
                    ->joinSub(function (Builder $query) use ($category) {
                        $query
                            ->select('c.id')
                            ->from('categories as c')
                            ->whereBetween('id', [$category->_lft + 1, $category->_rgt]);
                    }, 'categoryIds', 'pc.category_id', '=', 'categoryIds.id')
                    ->whereRaw('pc.product_id = products.id');
            })
            ->get();
    }
}
