<?php


namespace Modules\Export\Services\Generator;


use Illuminate\Support\Arr;
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

        $products = $this->productRepository->getProductsForMerchant(true);

        foreach ($products as $product) {
            fputcsv($file, $this->transform($product));
        }
    }

    public function transform($data)
    {
        return $data;
    }
}
