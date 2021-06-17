<?php


namespace Modules\Export\Services\Generator\Market;


use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Product\Repositories\ProductRepository;

class FacebookMarketGenerator implements GeneratorInterface
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {}

    public function generate(array $parameters)
    {
        $filePath = storage_path('app/public') . '/' . Arr::get($parameters, 'filename') . '.csv';

        $file = fopen($filePath, 'w');

        fputcsv($file, array('id', 'title', 'description', 'availability', 'condition', 'price', 'link', 'image_link', 'brand'));

        $products = $this->productRepository->getProductsForMerchant($parameters);

        foreach ($products as $product) {
            fputcsv($file, $this->transform($product));
        }
    }

    public function transform($product)
    {
        $productVariation = $product->productVariations->first();

        return [
            $product->id,
            $product->name,
            $product->short_description,
            $this->getAvailabilityByMerchant($productVariation->availability),
            'new',
            $productVariation->price . ' ' . Str::upper($productVariation->currency->code),
            route('product-view', [
                'slug' => $product->slug,
                'id' => $product->id,
            ]),
            url($product->image),
            $product->brand->name,
        ];
    }

    private function getAvailabilityByMerchant($value)
    {
        switch ($value) {
            case 1:
                return 'in stock';
                break;
            case 2:
                return 'available for order';
                break;
            default:
                return 'out of stock';
        }
    }
}
