<?php

namespace Modules\Achievement\Http\Resources;

use App\Http\Resources\BaseJsonResource;
use Modules\Achievement\Models\Achievement;

/**
 * Class AchievementResource
 * @package Modules\Achievement\Http\Resources
 * @mixin Achievement
 */
class AchievementResource extends BaseJsonResource
{
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
