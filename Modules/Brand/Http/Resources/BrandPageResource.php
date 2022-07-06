<?php

namespace Modules\Brand\Http\Resources;

use App\Http\Resources\BaseJsonResource;

class BrandPageResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
