<?php

namespace Modules\Category\Http\Resources;

use App\Http\Resources\BaseJsonResource;

class CategoryPageResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
