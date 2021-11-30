<?php

namespace Modules\Cabinet\Http\Resources;

use App\Http\Resources\BaseJsonResource;

class CabinetResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
