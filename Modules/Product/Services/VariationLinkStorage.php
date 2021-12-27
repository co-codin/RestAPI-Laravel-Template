<?php


namespace Modules\Product\Services;


use Illuminate\Database\Eloquent\Collection;
use Modules\Product\Dto\VariationLinkDtoCollection;
use Modules\Product\Models\ProductVariation;
use Modules\Product\Models\VariationLink;
use Modules\Product\Dto\VariationLinkDto;

class VariationLinkStorage
{
    /**
     * @throws \Exception
     * @return Collection|VariationLink[]
     */
    public function store(ProductVariation $productVariation, VariationLinkDtoCollection $variationLinkDtoCollection): Collection
    {
        return $productVariation->variationLinks()->createMany($variationLinkDtoCollection->toArray());
    }

    /**
     * @throws \Exception
     */
    public function update(VariationLink $variationLink, VariationLinkDto $variationLinkDto): VariationLink
    {
        if (!$variationLink->update($variationLinkDto->toArray())) {
            throw new \Exception('Can not update Variation Link');
        }

        return $variationLink;
    }

    /**
     * @throws \Exception
     */
    public function delete(VariationLink $variationLink): void
    {
        if (!$variationLink->delete()) {
            throw new \Exception('Can not delete Variation Link');
        }
    }
}
