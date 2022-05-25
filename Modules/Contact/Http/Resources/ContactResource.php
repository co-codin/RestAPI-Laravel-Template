<?php

namespace Modules\Contact\Http\Resources;

use App\Http\Resources\BaseJsonResource;

class ContactResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
