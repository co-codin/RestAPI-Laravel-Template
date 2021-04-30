<?php

namespace Modules\Product\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Product\Models\Product;

class ProductConfiguratorStorage
{
    public function update(Product $product, array $variants)
    {
        DB::beginTransaction();

        $dataWithId = collect($variants)->filter(fn($item) => Arr::exists($item, 'id'));
        $dataWithoutId = collect($variants)->filter(fn($item) => !Arr::exists($item, 'id'));

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
            $product->productVariants()
                ->whereNotIn('id', $collection->pluck('id')->toArray())
                ->delete()
            ;
        } catch (\Exception $e) {
            DB::rollback();
        }

        foreach ($collection as $item) {
            try {
                $productVariantQuery = $product->productVariants()->where('id', $item['id']);
                if ($productVariantQuery->exists()) {
                    $productVariantQuery->update(Arr::except($item, 'id'));
                }
            } catch (\Exception $e) {
                DB::rollback();
            }
        }
    }

    protected function handleNewData(Product $product, Collection $collection)
    {
        try {
            $product->productVariants()->createMany($collection->toArray());
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}
