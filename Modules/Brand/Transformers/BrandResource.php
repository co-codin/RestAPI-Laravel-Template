<?php

namespace Modules\Brand\Transformers;

use App\Transformers\BaseJsonResource;

class BrandResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
