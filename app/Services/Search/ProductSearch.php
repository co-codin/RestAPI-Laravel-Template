<?php

namespace App\Services\Search;

use App\Services\Interfaces\SearchInterface;
use Modules\Product\Models\Product;

class ProductSearch implements SearchInterface
{
    public function search($query, array $mapping)
    {
        $builder = Product::query()->where([

        ]);

        return $builder;
    }
}
