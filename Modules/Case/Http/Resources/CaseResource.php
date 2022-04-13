<?php

namespace Modules\Case\Http\Resources;

use App\Http\Resources\BaseJsonResource;

class CaseResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
