<?php


namespace Modules\Product\Repositories;


use App\Enums\Status;
use App\Repositories\BaseRepository;
use Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Modules\Product\Repositories\Criteria\ProductRequestCriteria;
use Modules\Filter\Concerns\SearchableRepository;

class ProductRepository extends BaseRepository
{
    use SearchableRepository;

    public function model()
    {
        return Product::class;
    }

    public function boot()
    {
        $this->pushCriteria(ProductRequestCriteria::class);
    }

    public function getProductsForMerchant($withPrice)
    {
        return Product::select([
            'products.id',
            'products.name',
            'products.slug',
            'products.brand_id',
            'products.image',
            'products.short_description'
        ])
            ->with([
                'productVariations.currency',
                'category',
                'brand',
                'images',
                'properties',
            ])
            ->where('products.status', Status::ACTIVE)
            ->whereHas('productVariations', function ($query) use ($withPrice) {
                $query->where('product_variations.is_enabled', true);

                if ($withPrice) {
                    $query->where('product_variations.is_price_visible', true);
                } else {
                    $query->where(function($q) {
                        $q->orWhere('product_variations.is_price_visible', false)
                            ->orWhere('product_variations.price', null);
                    });
                }
            })
            ->whereHas('brand', function ($query) {
                $query->where('brands.status', Status::ACTIVE);
            })
            ->whereNotNull('short_description')
            ->get();
    }

    public function indexForProducts()
    {
        return Product::query()
            ->where('status', '=', Status::ACTIVE)
            ->whereHas('productVariations', function (Builder $query) {
                $query->where('status', '=', Status::ACTIVE);
            })
//            ->whereHas('categories', function (Builder $query) {
//                $query->where('status', '=', Status::ACTIVE);
//            })
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
            ->get(['id', 'name', 'slug', 'brand_id'])
            ;

    }
}
