<?php


namespace Modules\Product\Repositories;


use App\Enums\Status;
use App\Repositories\BaseRepository;
use Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Modules\Product\Repositories\Criteria\ProductRequestCriteria;

class ProductRepository extends BaseRepository
{
    public function model()
    {
        return Product::class;
    }

    public function boot()
    {
        $this->pushCriteria(ProductRequestCriteria::class);
    }

    public function indexForProducts()
    {
        return Product::query()
            ->where('status', '=', Status::ACTIVE)
            ->whereHas('productVariations', function (Builder $query) {
                $query->where('status', '=', Status::ACTIVE);
            })
            ->whereHas('category', function (Builder $query) {
                $query->where('status', '=', Status::ACTIVE);
            })
            ->whereHas('brand', function (Builder $query) {
                $query->where('status', '=', Status::ACTIVE);
            })
            ->with([
                'categories',
                'brand',
                'productVariations.currency',
                'properties',
                'category',
            ])
            ->get(['id', 'name', 'slug', 'status', 'brand_id']);
    }
}
