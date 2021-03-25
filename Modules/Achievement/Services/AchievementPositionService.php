<?php

namespace Modules\Achievement\Services;

use Modules\Achievement\Models\Achievement;

class AchievementPositionService
{
    public function modifyPosition($positions)
    {
        foreach ($positions as $position) {
            Achievement::query()
                ->where('id', $position['id'])
                ->update(['position' => $position['position']]);
        }
    }
}
