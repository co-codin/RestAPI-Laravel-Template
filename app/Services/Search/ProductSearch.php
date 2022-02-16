<?php

namespace App\Services\Search;

use App\Services\Interfaces\SearchInterface;
use Modules\Product\Models\Product;

class ProductSearch implements SearchInterface
{
    protected $model = Product::class;

    public function search($query, array $mapping)
    {
        dd($query, $mapping);
    }
}
