<?php

namespace Modules\News\Http\Resources;

use App\Helpers\TextFormatHelper;
use App\Http\Resources\BaseJsonResource;

class NewsPageResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'formatted_full_description' => TextFormatHelper::replaceExternalLinks($this->full_description),
        ]);
    }
}
