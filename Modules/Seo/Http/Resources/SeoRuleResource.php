<?php

namespace Modules\Seo\Http\Resources;

use App\Transformers\BaseJsonResource;
use Modules\Seo\Models\SeoRule;

/**
 * Class SeoRuleResource
 * @package Modules\Seo\Http\Resources
 * @mixin SeoRule
 */
class SeoRuleResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'seo' => new SeoResource($this->whenLoaded('seo')),
        ]);
    }
}
