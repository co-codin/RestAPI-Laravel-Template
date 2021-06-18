<?php


namespace Modules\Export\Services\Generator\Side;


use Modules\Product\Enums\ProductVariationStock;
use Modules\Product\Repositories\ProductRepository;

class OffersGenerator
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {}

    public function getOffers(array $parameters): array
    {
        $offers = [];

        foreach ($this->productRepository->getProductsForMerchant($parameters) as $product) {
            $pictures = collect($product->image)
                ->map(fn($image) => url($image))
                ->toArray();

            $variation = $product->productVariations->where('is_enabled', '=', true)->first();




        }
    }
}
