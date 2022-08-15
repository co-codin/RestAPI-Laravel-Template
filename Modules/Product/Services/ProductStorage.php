<?php

namespace Modules\Product\Services;

use Illuminate\Support\Arr;
use Modules\Product\Dto\ProductDto;
use Modules\Product\Enums\Availability;
use Modules\Product\Events\ProductSaved;
use Modules\Product\Models\Product;

class ProductStorage
{
    public function store(ProductDto $productDto)
    {
        $attributes = $productDto->toArray();

        if (Arr::exists($attributes, 'documents')) {
            $attributes = $this->handleWithDocuments($attributes);
        }

        $product = Product::query()->create($attributes);

        $this->syncCategories($product, $productDto->categories);

        $product->productVariations()->create([
            'name' => $product->brand->name . ' ' . $product->name,
            'availability' => Availability::UNDER_THE_ORDER,
            'condition_id' => 61, // новый
        ]);

        event(new ProductSaved($product));

        return $product;
    }

    public function update(Product $product, ProductDto $productDto)
    {
        $attributes = $productDto->toArray();

        if (Arr::exists($attributes, 'documents')) {
            $attributes = $this->handleWithDocuments($attributes);
        }

        if ($productDto->categories) {
            $this->syncCategories($product, $productDto->categories);
        }

        if (!$product->update($attributes)) {
            throw new \LogicException('can not update product.');
        }

        event(new ProductSaved($product));

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
                $path = $this->fileUploader->upload($document['file']);
                $document['file'] = $path;
            }
            return $document;
        })->toArray();

        return $attributes;
    }

    protected function syncCategories(Product $product, array $categories)
    {
        $product->categories()->sync(
            collect($categories)
                ->keyBy('id')
                ->map(fn($item) => Arr::except($item, 'id'))
                ->toArray()
        );

        activity()
            ->on($product)
            ->withProperties([
                'type' => 'category',
                'old' => $product->categories,
                'new' => $categories,
            ])
            ->event('updated');
    }
}
