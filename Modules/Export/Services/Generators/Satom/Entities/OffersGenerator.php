<?php


namespace Modules\Export\Services\Generators\Satom\Entities;

use Bukashk0zzz\YmlGenerator\Model\Offer\OfferSimple;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Modules\Product\Enums\Availability;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\ProductRepository;

class OffersGenerator
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {}

    public function getOffers(?array $filter = null): array
    {
        $offers = [];

        $this->productRepository->getProductsForFeed($filter)->chunk(500, function(Collection $products) use (&$offers) {

            /** @var Product[] $products */
            foreach($products as $product) {

                $pictures = collect($product->image)
                    ->merge($product->images->pluck('image'))
                    ->map(fn($image) => \Storage::disk('public')->url($image))
                    ->toArray();

                $variation = $product->mainVariation;

                $name = $product->category->product_name . ' ' . $product->brand->name . ' ' . $product->name;

                $offer = (new OfferSimple())
                    ->setId($product->id)
                    ->setAvailable((int) $variation->availability === Availability::InStock)
                    ->setPictures($pictures)
                    ->setDescription($product->short_description)
                    ->setUrl($product->siteUrl)
                    ->setDelivery(true)
                    ->setName(trim($name))
                    ->setCategoryId($product->category->id)
                    ->setVendor($product->brand->name);

                if($product->category->product_name) {
                    $offer->addCustomElement('typePrefix', $product->category->product_name);
                }

                if($variation->is_price_visible) {
                    $offer->setPrice($variation->price);
                    $offer->setCurrencyId(Str::upper($variation->currency->iso_code));
                }

                $offers[] = $offer;
            }
        });

        return $offers;
    }
}
