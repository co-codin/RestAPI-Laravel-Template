<?php

namespace Modules\Achievement\Services;

use App\Services\File\ImageUploader;
use Modules\Achievement\Dto\AchievementDto;
use Modules\Achievement\Models\Achievement;

class AchievementStorage
{
    public function __construct(protected ImageUploader $imageUploader) {}

    public function store(AchievementDto $achievementDto)
    {
        $attributes = $achievementDto->toArray();

        $attributes['image'] = $this->imageUploader->upload($achievementDto->image);

        return Achievement::query()->create($attributes);
    }

    public function update(Achievement $achievement, AchievementDto $achievementDto)
    {
        $attributes = $achievementDto->toArray();

        $attributes['image'] = $this->imageUploader->upload($achievementDto->image);

        if (!$achievement->update($attributes)) {
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
