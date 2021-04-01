<?php

namespace Modules\Seo\Http\Resources;

use App\Transformers\BaseJsonResource;

class SeoRuleResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
