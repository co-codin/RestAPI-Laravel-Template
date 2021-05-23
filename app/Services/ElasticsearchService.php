<?php


namespace App\Services;


use Modules\Product\Models\Product;

class ElasticsearchService
{
    public function indexForProducts()
    {
        return Product::query()->fromQuery("

        ");
    }
}
