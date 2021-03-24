<?php

namespace Modules\Brand\Transformers;

use App\Enums\Status;
use App\Transformers\BaseJsonResource;

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
