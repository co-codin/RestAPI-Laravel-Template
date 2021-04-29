<?php


namespace Modules\Product\Services;


use Illuminate\Support\Facades\Storage;
use Modules\Product\Models\Product;

class ProductDocumentStorage
{
    public function update(Product $product, array $documents)
    {
        collect($documents)->each(function ($document) {
            dump($document);
//            if ($document['file']) {
//                $path = Storage::putFile("documents/{$document['name']}", $document['file']);
//
//            }

        });

    }
}
