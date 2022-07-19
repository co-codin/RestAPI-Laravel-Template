<?php

namespace Modules\Geo\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Geo\Models\City::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->city,
            'slug' => $this->faker->unique()->slug(),
            'status' => 1,
            'is_default' => 2,
            'coordinate' => [
                'lat' => 123,
                'long' => 456,
            ]
        ];
    }
}

