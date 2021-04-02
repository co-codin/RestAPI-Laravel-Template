<?php

namespace Modules\Achievement\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Achievement\Models\Achievement;

class AchievementFactory extends Factory
{
    protected $model = Achievement::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(4),
            'image' => $this->faker->imageUrl(),
            'is_enabled' => $this->faker->boolean,
        ];
    }
}

