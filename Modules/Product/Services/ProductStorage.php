<?php

namespace Modules\Product\Services;

use App\Services\File\ImageUploader;
use Illuminate\Support\Arr;
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

        $product->categories()->sync(
            collect($productDto->categories)
                ->keyBy('id')
                ->map(fn($item) => Arr::except($item, 'id'))
                ->toArray()
        );

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
            $product->categories()->sync(
                collect($productDto->categories)
                    ->keyBy('id')
                    ->map(fn($item) => Arr::except($item, 'id'))
                    ->toArray()
            );
        }

        if (!$product->update($attributes)) {
            throw new \LogicException('can not update product.');
        }

        return $product;
    }
}
