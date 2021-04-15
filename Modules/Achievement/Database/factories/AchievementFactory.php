<?php

namespace Modules\Achievement\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Modules\Achievement\Models\Achievement;

class AchievementFactory extends Factory
{
    protected $model = Achievement::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(4),
            'is_enabled' => $this->faker->boolean,
        ];
    }
}

