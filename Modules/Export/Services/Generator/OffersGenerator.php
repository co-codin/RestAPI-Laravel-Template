<?php


namespace Modules\Export\Services\Generator;


use Bukashk0zzz\YmlGenerator\Model\Offer\OfferParam;
use Bukashk0zzz\YmlGenerator\Model\Offer\OfferSimple;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Product\Enums\Availability;
use Modules\Product\Models\ProductVariation;
use Modules\Product\Repositories\ProductRepository;

class OffersGenerator
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {}

    public function getOffers(array $parameters): array
    {
        $offers = [];
        $price = null;
        $short_description = null;
        $products = $this->productRepository->getProductsForMerchant($parameters);

        foreach ($products as $product) {
            $pictures = collect($product->images)
                ->map(fn($image) => config('app.storage_url') . $image)
                ->toArray();

            $offer = (new OfferSimple())
                ->setId($product->id)
                ->setPictures($pictures)
                ->setUrl(config('app.site_url') . "/product/$product->slug/$product->id")
                ->setCategoryId($product->category->id)
                ->setDelivery(true)
                ->setName($product->brand->name . ' ' . $product->name)
                ->setVendor($product->brand->name)
                ->addCustomElement('typePrefix', $product->category->product_name);

            /** @var ProductVariation $variation */
            $variation = $product->productVariations
                ->where('is_enabled', '=', true)
                ->first();

            if (!is_null($variation)) {
                $offer->setAvailable($variation->availability === Availability::InStock);
            }

            if (array_key_exists('price', $parameters)) {
                $price = (bool) Arr::get($parameters, 'price');
            }

            if (array_key_exists('short_description', $parameters)) {
                $short_description = (bool) Arr::get($parameters, 'short_description');
            }

            if ($price) {
                $offer->setPrice($variation->price);
                $offer->setCurrencyId(Str::upper($variation->currency->iso_code));
            }

            if ($short_description) {
                $offer->setDescription($product->short_description);
            }

            foreach ($product->properties as $property) {
                $offer->addParam(
                    (new OfferParam())
                        ->setName($property->name)
                        ->setValue($property->pivot->value())
                );
            }

            $offers[] = $offer;
        }

        return $offers;
    }
}
