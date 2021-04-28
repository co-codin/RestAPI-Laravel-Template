<?php

namespace Modules\Product\Services;

use App\Services\File\ImageUploader;
use Modules\Product\Dto\ProductDto;
use Modules\Product\Models\Product;

class ProductStorage extends ProductBaseStorage
{
    public function __construct(protected ImageUploader $imageUploader) {}

    public function store(ProductDto $productDto)
    {
        $attributes = $productDto->toArray();
        $attributes['image'] = $this->imageUploader->upload($productDto->image);

        $product = Product::query()->create($attributes);

        $product->categories()->sync($this->groupBy($productDto->categories));

        $product->productVariants()->create([
            'name' => $product->brand->name . ' ' . $product->name
        ]);

        return $product;
    }

    public function update(Product $product, ProductDto $productDto)
    {
        $attributes = $productDto->toArray();

        if ($productDto->image) {
            $attributes['image'] = $this->imageUploader->upload($productDto->image);
        }

        if ($productDto->categories) {
            $product->categories()->detach();
            $product->categories()->sync($this->groupBy($productDto->categories));
        }

        if (!$product->update($attributes)) {
            throw new \LogicException('can not update product.');
        }

        return $product;
    }
}
