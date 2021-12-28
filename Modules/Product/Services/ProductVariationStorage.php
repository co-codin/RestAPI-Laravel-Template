<?php


namespace Modules\Product\Services;


use Illuminate\Database\Eloquent\Builder;
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

    public function deleteNonExistentVariations(): static
    {
        $ids = $this->variations->pluck('id')->filter()->unique();

        $this->product->productVariations()
            ->when($ids->isNotEmpty(), fn(Builder $query) => $query->whereNotIn('id', $ids))
            ->delete();

        $this->deleteNonExistentVariationLinks();

        return $this;
    }

    public function createNewVariations(): static
    {
        $newVariations = $this->variations
            ->filter(fn(array $variation): bool => !Arr::exists($variation, 'id'));

        $this->product->productVariations()->createMany($newVariations);

        return $this;
    }

    public function updateExistingVariations(): static
    {
        $this->variations
            ->filter(fn(array $variation): bool => Arr::exists($variation, 'id'))
            ->each(function($variation) {
                $model = ProductVariation::find($variation['id']);
                $model?->update($variation);
            });

        return $this;
    }

    protected function deleteNonExistentVariationLinks(): static
    {
        $variationLinkIds = collect(\request()->input('variations.*.links.*.id'))
            ->filter(fn(?int $id): bool => !is_null($id));

        $this->product->productVariations
            ->map(function (ProductVariation $productVariation) use ($variationLinkIds) {
                $productVariation
                    ->variationLinks()
                    ->when($variationLinkIds->isNotEmpty(), fn(Builder $query) => $query->whereNotIn('id', $variationLinkIds))
                    ->delete();
            });

        return $this;
    }

    protected function createNewVariationLinks(): static
    {
        return $this;
    }

    protected function updateExistingVariationLinks(): static
    {
        return $this;
    }
}
