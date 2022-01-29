<?php


namespace Modules\Export\Services\Generators\GoogleMerchant;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Modules\Export\Models\Export;
use Modules\Export\Services\Generators\FeedGeneratorInterface;
use Modules\Product\Repositories\ProductRepository;
use Vitalybaev\GoogleMerchant\Feed;

class GoogleMerchantFeedGenerator implements FeedGeneratorInterface
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {}

    public function generate(Export|Model $export): void
    {
        $feed = new Feed(
            config('app.name'),
            config('app.site_url'),
            config('app.info'),
        );

        $products = $this->productRepository->getProductsForFeed($export->filter)->get();

        foreach ($products as $product) {
            $feed->addProduct((new ProductGoogleGeneratorConverter($product))->toXml());
        }

        $feedXml = $feed->build();

        File::put(storage_path('app/public/feeds') . '/' . $export->filename . '.xml', $feedXml);
    }
}
