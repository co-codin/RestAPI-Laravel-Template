<?php


namespace Modules\Category\Services;


use App\Enums\Status;
use Illuminate\Database\Query\Builder;
use Modules\Brand\Models\Brand;
use Modules\Category\Models\Category;

class CategoryBrandsField
{
    public function __invoke(Category $category)
    {
        return Brand::query()
            ->whereExists(function (Builder $query) use ($category) {
                $query->select('*')
                    ->from('product_category as pc')
                    ->leftJoin('products as p', 'pc.product_id', '=', 'p.id')
                    ->leftJoin('brands as b', 'p.brand_id', '=', 'b.id')
                    ->whereIn('pc.category_id', $category->descendants->pluck('id')->add($category->id))
                    ->where('p.status', '=', Status::ACTIVE)
                    ->whereRaw('p.brand_id = brands.id');
            })
            ->get();
    }
}
