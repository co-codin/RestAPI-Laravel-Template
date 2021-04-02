<?php

namespace Modules\Category\Http\Resources;

use App\Enums\Status;
use App\Transformers\BaseJsonResource;
use Modules\Category\Models\Category;

/**
 * Class CategoryResource
 * @package Modules\Category\Http\Resources
 * @mixin Category
 */
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
