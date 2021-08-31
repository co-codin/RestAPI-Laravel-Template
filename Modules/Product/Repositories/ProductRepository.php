<?php


namespace Modules\Product\Repositories;


use App\Enums\Status;
use App\Repositories\BaseRepository;
use Illuminate\Support\Arr;
use Modules\Product\Enums\ProductVariationStock;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\Criteria\ProductRequestCriteria;
use Modules\Search\Contracts\IndexableRepository;
use Spatie\QueryBuilder\QueryBuilder;

class ProductRepository extends BaseRepository implements IndexableRepository
{
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
            $in_stock = (bool) Arr::get($parameters, 'in_stock');
        }

        if (array_key_exists('short_description', $parameters)) {
            $short_description = (bool) Arr::get($parameters, 'short_description');
        }

        if (array_key_exists('price', $parameters)) {
            $price = (bool) Arr::get($parameters, 'price');
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

        $query->whereHas('brand', function ($query) use ($brands) {
            $query->where('brands.status', Status::ACTIVE);
        });

        if ($brands) {
            $query->whereIn('brand_id', $brands);
        }

        if ($categories) {
            $query->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('id', $categories);
            });
        }

        $query->whereHas('productVariations', function ($query) use ($price, $in_stock, $stock_type) {
            $query->where('product_variations.is_enabled', '=', true);

            if ($price) {
                $query->where('product_variations.is_price_visible', '=', true);
            } else {
                $query->where(function($q) {
                    $q->orWhere('product_variations.is_price_visible', '=', false)
                        ->orWhere('product_variations.price', '=', null);
                });
            }

            if ($in_stock) {
                $query->where('product_variations.availability', '=', ProductVariationStock::InStock);
            }

            $query->where('product_variations.stock_type', $stock_type ? '=' : '!=', null);
        });

        $query->where('short_description', $short_description ? '=' : '!=', null);

        return $query->get();
    }

    public function getItemsToIndex()
    {
        return $this->scopeQuery(function (QueryBuilder $builder) {
            return $builder->with('brand', 'category');
        });
    }
}
