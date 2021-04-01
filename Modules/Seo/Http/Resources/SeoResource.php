<?php

namespace Modules\Seo\Http\Resources;

use App\Transformers\BaseJsonResource;

class SeoResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
