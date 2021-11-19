<?php


namespace Modules\Product\Services;


use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariation;

class ProductVariationStorage
{
    private Product $product;

    private Collection $variations;

    public function __construct(Product $product, array $variations)
    {
        $this->product = $product;
        $this->variations = collect($variations);
    }

    public function deleteNonExistentVariations()
    {
        $ids = $this->variations->pluck('id')->filter()->unique();

        $this->product->productVariations()
            ->when($ids->isNotEmpty(), fn($query) => $query->whereNotIn('id', $ids))
            ->delete();

        return $this;
    }

    public function createNewVariations()
    {
        $newVariations = $this->variations->filter(fn($item) => !Arr::exists($item, 'id'));

        $this->product->productVariations()->createMany($newVariations);

        return $this;
    }

    public function updateExistingVariations()
    {
        $this->variations
            ->filter(fn($variation) => Arr::exists($variation, 'id'))
            ->each(function($variation) {
                $model = ProductVariation::find($variation['id']);
                if($model) {
                    $model->update($variation);
                }
            });

        return $this;
    }
}
