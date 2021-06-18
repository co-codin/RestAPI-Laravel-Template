<?php


namespace Modules\Export\Services\Generator\Side;


use Bukashk0zzz\YmlGenerator\Model\Offer\OfferParam;
use Bukashk0zzz\YmlGenerator\Model\Offer\OfferSimple;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
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
        $price = null;

        foreach ($this->productRepository->getProductsForMerchant($parameters) as $product) {
            $pictures = collect($product->image)
                ->map(fn($image) => url($image))
                ->toArray();

            $variation = $product->productVariations->where('is_enabled', '=', true)->first();

            $offer = (new OfferSimple())
                ->setId($product->id)
                ->setAvailable((int)$variation->in_stock === ProductVariationStock::InStock)
                ->setPictures($pictures)
                ->setDescription($product->short_description)
                ->setUrl(route('product-view', [$product->slug, $product->id]))
                ->setCategoryId($product->category->id)
                ->setDelivery(true)
                ->setName($product->brand->name . ' ' . $product->name)
                ->setVendor($product->brand->name)
                ->addCustomElement('typePrefix', $product->category->product_name)
            ;

            if (array_key_exists('price', $parameters)) {
                $price = (bool) Arr::get($parameters, 'price');
            }

            if ($price) {
                $offer->setPrice($variation->price);
                $offer->setCurrencyId(Str::upper($variation->currency->iso_code));
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
