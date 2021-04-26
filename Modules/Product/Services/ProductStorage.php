<?php


namespace Modules\Product\Services;


use App\Services\File\ImageUploader;
use Modules\Product\Dto\ProductDto;
use Modules\Product\Models\Product;

class ProductStorage
{
    public function __construct(protected ImageUploader $imageUploader) {}

    public function store(ProductDto $productDto)
    {
        $attributes = $productDto->toArray();
        $attributes['image'] = $this->imageUploader->upload($productDto->image);

        $product = Product::query()->create($attributes);

        $product->categories()->attach($productDto->categories);

        return $product;
    }
}
