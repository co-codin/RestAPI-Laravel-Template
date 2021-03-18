<?php

namespace Modules\Achievement\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Achievement\Models\Achievement;

class AchievementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Achievement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->string,
            'image' => $this->faker->imageUrl(),
            'is_enabled' => $this->faker->boolean,
        ];
    }
}

