<?php


namespace Modules\Achievement\Services;


use Modules\Achievement\Dto\AchievementPositionDto;
use Modules\Achievement\Models\Achievement;

class AchievementPositionService
{
    public function modifyPosition(AchievementPositionDto $dto)
    {
        $counter = 0;
        foreach ($dto->ids as $id) {
            Achievement::query()->find($id)->update([
                'position' => $counter++
            ]);
        }
    }
}
