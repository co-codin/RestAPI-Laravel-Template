<?php


namespace Modules\Achievement\Services;


use Modules\Achievement\Dto\AchievementDto;
use Modules\Achievement\Models\Achievement;

class AchievementStorage
{
    public function store(AchievementDto $achievementDto)
    {
        $achievement = Achievement::query()->create($achievementDto->toArray());
        return $achievement;
    }

    public function update(int $achievementId, AchievementDto $achievementDto)
    {
        $achievement = Achievement::query()->find($achievementId)->update($achievementDto->toArray());
        return $achievement;
    }

    public function delete(int $achievementId)
    {
        return Achievement::query()->find($achievementId)->delete();
    }
}
