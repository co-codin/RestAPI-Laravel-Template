<?php

namespace Modules\Seo\Http\Resources;

use App\Transformers\BaseJsonResource;
use Modules\Seo\Models\Seo;

/**
 * Class SeoResource
 * @package Modules\Seo\Http\Resources
 * @mixin Seo
 */
class SeoResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return [
            "is_enabled" => $this->is_enabled,
            'type' => $this->type,
            'title' => $this->title,
            'h1' => $this->h1,
            'description' => $this->description,
            'meta_tags' => $this->meta_tags,
        ];
    }
}
