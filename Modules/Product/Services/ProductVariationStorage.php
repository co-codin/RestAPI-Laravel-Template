<?php


namespace Modules\Product\Services;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection as SupportCollection;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariation;
use Modules\Product\Models\VariationLink;

class ProductVariationStorage
{
    private Product $product;

    private SupportCollection $variations;

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
        $newVariationsData = $this->variations
            ->filter(fn(array $variation): bool => !Arr::exists($variation, 'id'));

        foreach ($newVariationsData as $variationData) {
            $productVariation = $this->product->productVariations()->create(Arr::except($variationData, 'links'));

            if (Arr::exists($variationData, 'links')) {
                $productVariation->variationLinks()->createMany($variationData['links']);
            }
        }

        return $this;
    }

    public function updateExistingVariations(): static
    {
        $this->variations
            ->filter(fn(array $variation): bool => Arr::exists($variation, 'id'))
            ->each(function(array $variationData) {
                $variationWithoutLinks = Arr::except($variationData, 'links');
                $model = ProductVariation::find($variationWithoutLinks['id']);
                $model?->update($variationWithoutLinks);

                if (Arr::exists($variationData, 'links')) {
                    foreach ($variationData['links'] as $link) {
                        if (Arr::exists($link, 'id')) {
                            $model->variationLinks()->update(Arr::except($link, 'id'));
                        } else {
                            $model->variationLinks()->create($link);
                        }
                    }
                }
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
