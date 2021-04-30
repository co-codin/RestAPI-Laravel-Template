<?php


namespace Modules\Product\Services;


use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Product\Models\Product;

class ProductDocumentStorage
{
    public function update(Product $product, array $data)
    {
        $data['documents'] = collect($data['documents'])->map(function ($document) {
            if (Arr::exists($document, 'file')) {
                $file = $document['file'];
                $fileName = Str::uuid();
                $extension = $file->getClientOriginalExtension();

                Storage::disk('public')->put($path = "documents/{$fileName}.{$extension}", $file);

                $document['file'] = $path;
            }
            return $document;
        })->toArray();

        $product->update($data);

        return $product;
    }
}
