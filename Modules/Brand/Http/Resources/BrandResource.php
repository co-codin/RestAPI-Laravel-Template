<?php

namespace Modules\Brand\Http\Resources;

use App\Enums\Status;
use App\Transformers\BaseJsonResource;
use Modules\Brand\Models\Brand;

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
            'status' => $this->whenRequested('status', [
                'value' => $this->status,
                'description' => Status::getDescription($this->status),
            ]),
        ]);
    }
}
