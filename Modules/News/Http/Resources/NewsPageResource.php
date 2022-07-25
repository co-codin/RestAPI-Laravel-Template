<?php

namespace Modules\News\Http\Resources;

use App\Helpers\TextFormatHelper;
use App\Http\Resources\BaseJsonResource;

class NewsPageResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        $resource = parent::toArray($request);

        if ($this->full_description) {
            array_merge($resource, [
                'formatted_full_description' => TextFormatHelper::replaceExternalLinks($this->full_description),
            ]);
        }
        return $resource;
    }
}
