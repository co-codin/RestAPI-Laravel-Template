<?php


namespace Modules\Export\Services\Generators\Facebook;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Export\Models\Export;
use Modules\Export\Services\Generators\FeedGeneratorInterface;
use Modules\Product\Models\Product;
use Modules\Product\Repositories\ProductRepository;

class FacebookFeedGenerator implements FeedGeneratorInterface
{

    public function __construct(
        protected ProductRepository $productRepository
    ) {}

    public function generate(Export|Model $export): void
    {
        $file = fopen(storage_path("app/feeds/$export->filename.csv") , 'w');

        fputcsv($file, array('id', 'title', 'description', 'availability', 'condition', 'price', 'link', 'image_link', 'brand'));

        $products = $this->productRepository->getProductsForFeed($export->filter)->get();

        foreach ($products as $product) {
            fputcsv($file, $this->transform($product));
        }

        fclose($file);
    }

    protected function transform(Product $product)
    {
        return [
            $product->id,
            $product->name,
            $product->short_description ?? '',
            $this->transformAvailability($product->mainVariation->availability),
            'new',
            $product->mainVariation->price . ' ' . Str::upper($product->mainVariation->currency->iso_code),
            $product->siteUrl,
            $product->image ? \Storage::disk('public')->url($product->image): '',
            $product->brand->name,
        ];
    }

    private function transformAvailability($value)
    {
        return match ($value) {
            1 => 'in stock',
            2 => 'available for order',
            default => 'out of stock',
        };
    }
}
