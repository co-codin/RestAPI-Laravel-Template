<?php

namespace App\Services;

use App\Enums\Status;
use Illuminate\Support\Facades\DB;
use Modules\Product\Enums\ProductGroup;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariation;
use Modules\Product\Repositories\ProductRepository;

class HomePageService
{
    const COVID_PROPERTY_ID = 259;

    public function __construct(
        protected ProductRepository $productRepository
    ) {}

    public function all()
    {
//        $productsHotBuilder = $this->getProductsHot();
//        $productsRussiaBuilder = $this->getProductsRussia();
//        $productsCovidBuilder = $this->getProductsCovid();
//
//        return $productsHotBuilder->merge([
//            $productsRussiaBuilder, $productsCovidBuilder,
//        ])->all();
    }

    public function getProductsHot()
    {
        return $this->productRepository->findWhere([
            ['is_in_home', '=', true],
            ['status', '=', Status::ACTIVE],
            ['group_id', '=', ProductGroup::IMPOSSIBLE],
        ])
            ->scopeQuery(function($query) {
                $query->addSelect(['main_variation_id' => ProductVariation::select('product_variations.id')
                    ->whereColumn('product_id', 'products.id')
                    ->where('is_enabled', true)
                    ->leftJoin('currencies', 'currency_id', 'currencies.id')
                    ->orderByRaw('rate * price ASC')
                    ->take(1),
                ]);

                $query->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('product_property as pp')
                        ->whereColumn('pp.product_id', 'products.id')
                        ->where('pp.property_id', static::COVID_PROPERTY_ID)
                        ->whereJsonContains('pp.field_value_ids', 1);
                });

                $query
                    ->select(DB::raw(1))
                    ->from('product_variations as pv')
                    ->whereRaw('pv.product_id = products.id')
                    ->whereNotNull('pv.previous_price')
                    ->whereNotNull('pv.price')
                    ->where('pv.is_price_visible', true);
            })
            ->take(20)
            ->all();
    }


    public function getProductsRussia()
    {
        return Product::query()->get();
    }

    public function getProductsCovid()
    {
        return Product::query()->get();
    }

    public function getBrands()
    {

    }

    public function getBanners()
    {

    }

    public function getPublications()
    {

    }

    public function getNews()
    {

    }
}
