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

    public function update(int $achievementId, AchievementDto $achievementDto)
    {
        return Achievement::query()->find($achievementId)->update($achievementDto->toArray());
    }

    public function delete(int $achievementId)
    {
        return Achievement::query()->find($achievementId)->delete();
    }
}
