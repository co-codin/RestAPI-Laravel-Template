<?php

namespace Modules\Category\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Category\Models\Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'product_name' => $this->faker->name,
            'image' => $this->faker->imageUrl(),
            'website' => $this->faker->word,
            'full_description' => $this->faker->paragraph,
        ];
    }
}

