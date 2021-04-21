<?php

namespace Modules\Filter\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Category\Models\Category;
use Modules\Filter\Enums\FilterType;
use Modules\Property\Models\Property;

class FilterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Filter\Models\Filter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->word(4),
            'property_id' => Property::factory(),
            'type' => FilterType::getRandomValue(),
            'category_id' => Category::factory(),
            'is_enabled' => $this->faker->boolean,
            'is_default' => $this->faker->boolean,
            'description' => $this->faker->sentence(10),
        ];
    }
}

