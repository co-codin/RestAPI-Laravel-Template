<?php


namespace Modules\Product\Services;


use Illuminate\Support\Arr;
use Modules\Product\Models\Product;

class ProductPropertyStorage
{
    public function update(Product $product, array $properties)
    {
        $product->properties()->sync(
            collect($properties)
                ->keyBy('id')
                ->map(fn($item) => Arr::except($item, 'id'))
                ->toArray()
        );
    }
}
