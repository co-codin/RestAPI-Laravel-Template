<?php

namespace Modules\Product\Services;

use Illuminate\Support\Arr;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariant;

class ProductConfiguratorStorage
{
    public function update(Product $product, array $variants)
    {
        $dataWithId = collect($variants)->map(fn($item) => Arr::exists($item, 'id'))->toArray();
        $dataWithoutId = collect($variants)->map(fn($item) => !Arr::exists($item, 'id'))->toArray();


//        ProductVariant::query()->get();
    }
}
