<?php


namespace Modules\Category\Services;


use App\Enums\Status;
use Illuminate\Database\Query\Builder;
use Modules\Brand\Models\Brand;
use Modules\Category\Models\Category;
use Modules\Product\Models\Product;

class CategoryBrandsField
{
    public function __invoke($category)
    {
        return Brand::query()
            ->selectRaw('brands.*, COUNT(*) as categoryProductCount')
            ->join('products', 'products.brand_id', 'brands.id')
            ->whereExists(function (Builder $query) use ($category) {
                return $query->selectRaw('1')
                    ->from('product_category as pc')
                    ->whereColumn('pc.product_id', 'products.id')
                    ->whereIn('pc.category_id', $category->descendants->pluck('id')->add($category->id));
            })
            ->where('products.status', Status::ACTIVE)
            ->groupBy('brands.id')
            ->get();
    }
}
