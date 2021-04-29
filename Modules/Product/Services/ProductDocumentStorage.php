<?php


namespace Modules\Product\Services;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Modules\Product\Models\Product;

class ProductDocumentStorage
{
    public function update(Product $product, array $data)
    {
        $data['documents'] = collect($data['documents'])->map(function ($document) {
            if (Arr::exists($document, 'file')) {
                $path = Storage::putFile("documents", $document['file']);
                $document['file'] = $path;
            }
            return $document;
        })->toArray();

        $product->update($data);
    }
}
