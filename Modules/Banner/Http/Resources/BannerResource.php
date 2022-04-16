<?php

namespace Modules\Banner\Http\Resources;

use App\Http\Resources\BaseJsonResource;

class BannerResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
