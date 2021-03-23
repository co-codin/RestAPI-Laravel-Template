<?php

namespace Modules\Achievement\Services;

use Modules\Achievement\Models\Achievement;

class AchievementPositionService
{
    public function modifyPosition($postions)
    {
        foreach ($postions as $position) {
            Achievement::query()->find($position['id'])->update([
                'position' => $position['position']
            ]);
        }
    }
}
