<?php

namespace Modules\Achievement\Transformers;

use App\Transformers\BaseJsonResource;

class AchievementResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
