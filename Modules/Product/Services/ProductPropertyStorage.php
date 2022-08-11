<?php


namespace Modules\Product\Services;


use Illuminate\Support\Arr;
use Modules\Product\Models\Product;

class ProductPropertyStorage
{
    public function update(Product $product, array $properties)
    {
        activity()
            ->performedOn($product)
            ->event('updated')
            ->withProperties([
                'type' => 'property',
                'old' => $product->properties,
                'new' => $properties,
            ])
        ;

        $product->properties()->sync(
            collect($properties)
                ->keyBy('id')
                ->map(fn($item) => Arr::only($item, [
                    'field_value_ids',
                    'position',
                    'is_important',
                    'important_position',
                    'important_value',
                    'pretty_key',
                    'pretty_value',
                    'is_in_variations',
                ]))
                ->toArray()
        );
    }
}
