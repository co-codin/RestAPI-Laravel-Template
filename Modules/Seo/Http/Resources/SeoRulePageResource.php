<?php

namespace Modules\Seo\Http\Resources;

use App\Http\Resources\BaseJsonResource;

class SeoRulePageResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'seo' => new SeoResource($this->whenLoaded('seo')),
        ]);
    }
}
