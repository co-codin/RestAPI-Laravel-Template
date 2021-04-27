<?php


namespace Modules\Product\Http\Resources;


use App\Transformers\BaseJsonResource;

class ProductVariantResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'product' => $this->whenLoaded('product'),
        ]);
    }
}
