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

    public function update(Achievement $achievement, AchievementDto $achievementDto)
    {
        if (!$achievement->update($achievementDto->toArray())) {
            throw new \LogicException('can not update achievement');
        }
        return $achievement;
    }

    public function delete(Achievement $achievement)
    {
        if (!$achievement->delete()) {
            throw new \LogicException('can not delete achievement');
        }
    }

    public function sort(array $achievements)
    {
        foreach ($achievements as $achievement) {
            Achievement::query()
                ->where('id', $achievement['id'])
                ->update(['position' => $achievement['position']]);
        }
    }
}
