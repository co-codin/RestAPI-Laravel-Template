<?php


namespace Modules\Product\Services;


use Illuminate\Support\Arr;
use Modules\Product\Models\Product;

class ProductPropertyStorage extends ProductBaseStorage
{
    public function update(Product $product, array $properties)
    {
        $properties = $this->groupBy($properties);
        $product->properties()->detach();

        $product->properties()->attach($properties);
    }
}
