<?php

namespace Modules\Property\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Property\Models\Property::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'is_hidden_from_product' => $this->faker->boolean,
            'is_hidden_from_comparison' => $this->faker->boolean,
        ];
    }
}

