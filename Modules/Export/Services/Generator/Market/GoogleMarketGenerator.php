<?php


namespace Modules\Export\Services\Generator\Market;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Modules\Product\Repositories\ProductRepository;
use Vitalybaev\GoogleMerchant\Feed;

class GoogleMarketGenerator implements GeneratorInterface
{
    public function __construct(
        protected GoogleMarketGenerator $googleMarketGenerator,
        protected ProductRepository $productRepository
    ) {}

    public function generate(array $parameters)
    {
        $feed = new Feed(
            config('services.google-market.company_name'),
            config('services.google-market.link'),
            config('services.google-market.description'),
        );

        $products = $this->productRepository->getProductsForMerchant($parameters);

        foreach ($products as $product) {
            $feed->addProduct($product->toXml());
        }

        $feedXml = $feed->build();

        File::put(storage_path('app/feeds') . '/' . Arr::get($parameters, 'filename') . '.xml', $feedXml);
    }
}
