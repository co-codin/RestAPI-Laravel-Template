<?php

namespace Modules\Achievement\Services;

use Modules\Achievement\Models\Achievement;

class AchievementPositionService
{
    public function modifyPosition($ids)
    {
        $counter = 0;
        foreach ($ids as $id) {
            Achievement::query()->find($id)->update([
                'position' => $counter++
            ]);
        }
    }
}
