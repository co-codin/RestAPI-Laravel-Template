<?php

namespace App\Services;

use Modules\Product\Models\Product;

class HomePageService
{
    public function all()
    {
        $productsHotBuilder = $this->getProductsHot();
        $productsRussiaBuilder = $this->getProductsRussia();
        $productsCovidBuilder = $this->getProductsCovid();



        return $productsHotBuilder->merge($productsRussiaBuilder, $productsCovidBuilder)->all();
    }

    public function getProductsHot()
    {
        return Product::query()->get();
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
