<?php

namespace Modules\Product\Services;

use App\Services\File\FileUploader;
use App\Services\File\ImageUploader;
use Illuminate\Support\Arr;
use Modules\Product\Dto\ProductDto;
use Modules\Product\Events\ProductSaved;
use Modules\Product\Models\Product;

class ProductStorage
{
    public function __construct(
        protected ImageUploader $imageUploader,
        protected FileUploader $fileUploader
    ) {}

    public function store(ProductDto $productDto)
    {
        $attributes = $productDto->toArray();

        if ($productDto->image) {
            $attributes['image'] = $this->imageUploader->upload($productDto->image);
        }

        if($productDto->booklet) {
            $attributes['booklet'] = $this->fileUploader->upload($productDto->booklet);
        }

        if (Arr::exists($attributes, 'documents')) {
            $attributes = $this->handleWithDocuments($attributes);
        }

        $product = Product::query()->create($attributes);

        $product->categories()->sync(
            collect($productDto->categories)
                ->keyBy('id')
                ->map(fn($item) => Arr::except($item, 'id'))
                ->toArray()
        );

        $product->productVariations()->create([
            'name' => $product->brand->name . ' ' . $product->name,
            'condition_id' => 61, // новый
        ]);

        event(new ProductSaved($product));

        return $product;
    }

    public function update(Product $product, ProductDto $productDto)
    {
        $attributes = $productDto->toArray();

        if($productDto->is_images_changed) {
            $attributes['image'] = $productDto->image
                ? $this->imageUploader->upload($productDto->image)
                : null;
        }

        if ($productDto->is_images_changed) {
            $product->images()->delete();
            if ($productDto->images) {
                foreach ($productDto->images as $image) {
                    $product->images()->create([
                        'image' => $image['image']
                    ]);
                }
            }
        }

        if ($productDto->booklet) {
            $attributes['booklet'] = $this->fileUploader->upload($productDto->booklet);
        } else {
            $attributes['booklet'] = null;
        }

        if (Arr::exists($attributes, 'documents')) {
            $attributes = $this->handleWithDocuments($attributes);
        }

        if ($productDto->categories) {
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

//        event(new ProductSaved($product));

        return $product;
    }

    public function delete(Product $product)
    {
        if (!$product->delete()) {
            throw new \LogicException('can not delete product.');
        }
    }

    protected function handleWithDocuments(array $attributes)
    {
        $attributes['documents'] = collect($attributes['documents'])->map(function ($document) {
            if (Arr::exists($document, 'file')) {
                $path = $this->fileUploader->upload( $document['file']);
                $document['file'] = $path;
            }
            return $document;
        })->toArray();

        return $attributes;
    }
}
