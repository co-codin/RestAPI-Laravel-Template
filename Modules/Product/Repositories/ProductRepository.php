<?php


namespace Modules\Product\Repositories;


use App\Enums\Status;
use App\Repositories\BaseRepository;
use Illuminate\Support\Arr;
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

    public function getProductsForMerchant(array $parameters)
    {
        $categories = [];
        $brands = [];
        $products = [];
        $stock_type = null;
        $in_stock = null;
        $short_description = null;
        $price = null;

        if (array_key_exists('categories', $parameters) && (bool) Arr::get($parameters, 'categories.selected')) {
            $categories = Arr::get($parameters, 'categories.ids');
        }

        if (array_key_exists('brands', $parameters) && (bool) Arr::get($parameters, 'brands.selected')) {
            $brands = Arr::get($parameters, 'brands.ids');
        }

        if (array_key_exists('products', $parameters) && (bool) Arr::get($parameters, 'products.selected')) {
            $products = Arr::get($parameters, 'products.ids');
        }

        if (array_key_exists('stock_type', $parameters)) {
            $stock_type = Arr::get($parameters, 'stock_type');
        }

        if (array_key_exists('in_stock', $parameters)) {
            $in_stock = Arr::get($parameters, 'in_stock');
        }

        if (array_key_exists('short_description', $parameters)) {
            $short_description = Arr::get($parameters, 'short_description');
        }

        if (array_key_exists('price', $parameters)) {
            $price = Arr::get($parameters, 'price');
        }

        $query = Product::query();

        if ($products) {
            $query->whereIn('id', $products);
        }

        $query->select([
            'products.id',
            'products.name',
            'products.slug',
            'products.brand_id',
            'products.image',
            'products.short_description'
        ])->with([
            'productVariations.currency',
            'category',
            'brand',
            'properties',
        ])->where('status', '=', Status::ACTIVE);

        $query->whereHas()


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
