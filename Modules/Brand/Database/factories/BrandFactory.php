<?php

namespace Modules\Brand\Database\factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Brand\Models\Brand::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'website' => $this->faker->url,
            'full_description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(),
            'short_description' => $this->faker->paragraph,
            'status' => Status::getRandomValue(),
            'is_in_home' => $this->faker->randomElement([true, false]),
            'position' => $this->faker->randomDigit,
            'country' => $this->faker->word,
        ];
    }
}

