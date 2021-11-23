<?php

namespace Modules\Product\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Product\Events\ProductSaved;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariation;

class ProductConfiguratorStorage
{
    public function update(Product $product, array $variations)
    {
        DB::beginTransaction();

        $this->deleteNonExistentVariations($product, $variations);
        $this->createNewVariations($product, $variations);
        $this->updateExistingVariations($product, $variations);

        DB::commit();

        event(new ProductSaved($product));
    }

    protected function deleteNonExistentVariations(Product $product, array $variations)
    {
        $ids = collect($variations)->pluck('id')->filter()->unique();

        $product->productVariations()
            ->when($ids->isNotEmpty(), fn($query) => $query->whereNotIn('id', $ids))
            ->delete();
    }

    protected function createNewVariations(Product $product, array $variations)
    {
        $newVariations = collect($variations)->filter(fn($item) => !Arr::exists($item, 'id'));

        $product->productVariations()->createMany($newVariations);
    }

    protected function updateExistingVariations(Product $product, array $variations)
    {
        collect($variations)
            ->filter(fn($variation) => Arr::exists($variation, 'id'))
            ->each(function($variation) use ($product) {
                $model = ProductVariation::find($variation['id']);
                if($model) {
                    $model->update($variation);
                }
            });
    }
}
