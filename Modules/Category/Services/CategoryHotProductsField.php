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
                    ->from('products as p')
                    ->whereRaw('p.id = products.id')
                    ->joinSub("
                        SELECT DISTINCT
                            pc.product_id
                        FROM
                            product_category as pc
                        JOIN (
                            SELECT
                                c.id
                            FROM
                                categories as c
                            JOIN (
                                SELECT
                                    _lft, _rgt
                                FROM
                                    categories
                                WHERE
                                    id = {$category->id}
                            ) as nodes
                            WHERE
                                id BETWEEN (nodes._lft + 1) and nodes._rgt
                        ) as categoryIds ON pc.category_id = categoryIds.id
                    ",
                        'p1', 'p1.product_id', '=', 'p.id');
            })
            ->get();
    }
}
