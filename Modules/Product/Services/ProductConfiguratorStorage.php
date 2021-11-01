<?php

namespace Modules\Product\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\Product;

class ProductConfiguratorStorage
{
    public function update(Product $product, array $variations)
    {
        DB::beginTransaction();

        $dataWithId = collect($variations)->filter(fn($item) => Arr::exists($item, 'id'));
        $dataWithoutId = collect($variations)->filter(fn($item) => !Arr::exists($item, 'id'));

        if (count($dataWithId)) {
            $this->handleExistingData($product, $dataWithId);
        }

        if (count($dataWithoutId)) {
            $this->handleNewData($product, $dataWithoutId);
        }

        DB::commit();
    }

    protected function handleExistingData(Product $product, Collection $collection)
    {
        try {
            $product->productVariations()->delete();
        } catch (\Exception $e) {
            DB::rollback();
        }

        foreach ($collection as $item) {
            try {
                $product->productVariations()->create(Arr::except($item, 'id'));
            } catch (\Exception $e) {
                DB::rollback();
            }
        }
    }

    protected function handleNewData(Product $product, Collection $collection)
    {
        try {
            $product->productVariations()->createMany($collection->toArray());
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}
