<?php

namespace Modules\Brand\Http\Resources;

use App\Enums\Status;
use App\Http\Resources\BaseJsonResource;
use Modules\Brand\Models\Brand;
use Modules\Seo\Http\Resources\SeoResource;

/**
 * Class BrandResource
 * @package Modules\Brand\Transformers
 * @mixin Brand
 */
class BrandResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'status' => $this->whenRequested('status', Status::fromValue($this->status)->toArray()),
            'seo' => new SeoResource($this->whenLoaded('seo')),
        ]);
    }
}
