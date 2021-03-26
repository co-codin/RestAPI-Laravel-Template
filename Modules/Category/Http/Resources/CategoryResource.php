<?php

namespace Modules\Category\Http\Resources;

use App\Enums\Status;
use App\Transformers\BaseJsonResource;

class CategoryResource extends BaseJsonResource
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
