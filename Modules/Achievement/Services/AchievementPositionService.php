<?php

namespace Modules\Achievement\Services;

use Modules\Achievement\Models\Achievement;

class AchievementPositionService
{
    public function modifyPosition($postions)
    {
        Achievement::query()->update(['position' => null]);

        foreach ($postions as $position) {
            Achievement::query()->find($position['id'])->update([
                'position' => $position['position']
            ]);
        }
    }
}
