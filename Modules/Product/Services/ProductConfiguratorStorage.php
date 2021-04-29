<?php

namespace Modules\Product\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariant;

class ProductConfiguratorStorage
{
    public function update(Product $product, array $variants)
    {
        $dataWithId = collect($variants)->filter(fn($item) => Arr::exists($item, 'id'));
        $dataWithoutId = collect($variants)->filter(fn($item) => !Arr::exists($item, 'id'));

        if (count($dataWithId)) {
            $this->handleExistingData($product, $dataWithId);
        }

        if (count($dataWithoutId)) {
            $this->handleNewData($product, $dataWithoutId);
        }
    }

    protected function handleExistingData(Product $product, Collection $collection)
    {
        $product->productVariants()
            ->whereNotIn('id', $collection->pluck('id')->toArray())
            ->delete()
        ;

        foreach ($collection as $item) {
            $productVariantQuery = $product->productVariants()->where('id', $item['id']);
            if ($productVariantQuery->exists()) {
                $productVariantQuery->update(Arr::except($item, 'id'));
            }
        }
    }

    protected function handleNewData(Product $product, Collection $collection)
    {
        $product->productVariants()->createMany($collection->toArray());
    }
}
