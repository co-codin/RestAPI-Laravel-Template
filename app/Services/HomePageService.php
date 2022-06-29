<?php

namespace App\Services;

use App\Enums\Status;
use Modules\Product\Enums\ProductGroup;
use Modules\Product\Models\Product;

class HomePageService
{
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
        return Product::query()
            ->where([
                ['is_in_home', '=', true],
                ['status', '=', Status::ACTIVE],
                ['group_id', '=', ProductGroup::IMPOSSIBLE],
            ])
            ->with(
                ['stockType' => function ($query) {
                    $query->select('value');
                }],
                ['category' => function ($query) {
                    $query->select('name');
                }],
                ['brand' => function ($query) {
                    $query->select('name');
                }],
                ['mainVariation' => function ($query) {
                    $query->select(['id', 'price', 'previous_price', 'is_price_visible', 'currency_id', 'stock_type']);
                }],
                ['mainVariation.currency' => function ($query) {
                    $query->select('rate');
                }],
                ['images' => function ($query) {
                    $query->select('image');
                }],
                ['productReviews' => function ($query) {
                    $query->select('ratings');
                }],
            )
            ->take(20)
            ->get();
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
