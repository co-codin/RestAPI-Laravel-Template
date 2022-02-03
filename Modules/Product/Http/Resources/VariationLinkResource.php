<?php

namespace Modules\Product\Http\Resources;

use App\Http\Resources\BaseJsonResource;
use Illuminate\Http\Request;
use Modules\Currency\Http\Resources\CurrencyResource;
use Modules\Product\Models\VariationLink;

/**
 * @mixin VariationLink
 */
class VariationLinkResource extends BaseJsonResource
{
    /**
     * @param Request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'productVariation' => new ProductVariationResource($this->whenLoaded('productVariation')),
            'currency' => new CurrencyResource($this->whenLoaded('currency')),
        ]);
    }
}
