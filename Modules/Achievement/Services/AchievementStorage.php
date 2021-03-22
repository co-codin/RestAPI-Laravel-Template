<?php

namespace Modules\Achievement\Services;

use Modules\Achievement\Dto\AchievementDto;
use Modules\Achievement\Models\Achievement;

class AchievementStorage
{
    public function store(AchievementDto $achievementDto)
    {
        return Achievement::query()->create($achievementDto->toArray());
    }

    public function update($achievement, AchievementDto $achievementDto)
    {
        if (!$achievement->update($achievementDto->toArray())) {
            throw new \LogicException('can not update achievement');
        }
        return $achievement;
    }

    public function delete($achievement)
    {
        return $achievement->delete();
    }
}
