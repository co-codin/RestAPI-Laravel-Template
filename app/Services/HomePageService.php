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
    public function __construct(
        protected ProductRepository $productRepository
    ) {}

    public function all()
    {
        $productsHotBuilder = $this->getProductsHot();
        $productsRussiaBuilder = $this->getProductsRussia();
        $productsCovidBuilder = $this->getProductsCovid();

        return $productsHotBuilder->merge([
            $productsRussiaBuilder, $productsCovidBuilder,
        ])->all();
    }

    public function getProductsHot()
    {
        $this->productRepository->findWhere([
            ['is_in_home', '=', true],
            ['status', '=', Status::ACTIVE],
            ['group_id', '=', ProductGroup::IMPOSSIBLE],
            [DB::raw(1), 'NOT EXIST']
        ])
            ->scopeQuery(function($query) {
                $query->addSelect(['main_variation_id' => ProductVariation::select('product_variations.id')
                    ->whereColumn('product_id', 'products.id')
                    ->where('is_enabled', true)
                    ->leftJoin('currencies', 'currency_id', 'currencies.id')
                    ->orderByRaw('rate * price ASC')
                    ->take(1),
                ]);
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
