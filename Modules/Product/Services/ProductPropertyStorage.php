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
                ->map(fn($item) => Arr::only($item, [
                    'field_value_ids',
                    'is_important',
                    'important_position',
                    'important_value',
                    'pretty_key',
                    'pretty_value',
                ]))
                ->toArray()
        );
    }
}
