<?php


namespace Modules\Product\Http\Resources;


use App\Http\Resources\BaseJsonResource;
use Modules\Product\Models\ProductAnalog;

/**
 * @mixin ProductAnalog
 */
class ProductAnalogResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'product' => new ProductResource($this->whenLoaded('product')),
            'analogs' => ProductResource::collection($this->whenLoaded('analogs')),
        ]);
    }
}
