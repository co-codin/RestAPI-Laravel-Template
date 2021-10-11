<?php


namespace Modules\Product\Repositories;


use App\Enums\Status;
use App\Repositories\BaseRepository;
use Illuminate\Support\Arr;
use Modules\Product\Enums\Availability;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\Criteria\ProductRequestCriteria;
use Modules\Search\Contracts\IndexableRepository;
use Modules\Search\Repositories\IndexableRepositoryTrait;
use Spatie\QueryBuilder\QueryBuilder;

class ProductRepository extends BaseRepository implements IndexableRepository
{
    use IndexableRepositoryTrait;

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
        $stock_type_id = null;
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

        if (array_key_exists('stock_type_id', $parameters)) {
            $stock_type_id = Arr::get($parameters, 'stock_type_id');
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

        if (!is_null($stock_type_id)) {
            $query->where('stock_type_id', $stock_type_id);
        }

        $query->whereHas('productVariations', function ($query) use ($price, $in_stock, $stock_type_id) {
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
                $query->where('product_variations.availability', '=', Availability::InStock);
            }
        });

        if (!is_null($short_description)) {
            $query->where('short_description', $short_description);
        }

        return $query->get();
    }

    public function getItemsToIndex()
    {
        return $this->scopeQuery(function (QueryBuilder $builder) {
            return $builder->with([
                'brand',
                'category',
                'categories',
                'properties',
                'productVariations',
                'category.ancestors' => function($query) {
                    $query->whereNull('parent_id');
                },
            ]);
        });
    }
}
