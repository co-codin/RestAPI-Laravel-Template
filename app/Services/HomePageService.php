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
        return $this->productRepository
            ->findWhere([
                'is_in_home' => true,
                'status' => Status::ACTIVE,
                'group_id' => ProductGroup::IMPOSSIBLE
            ])
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
