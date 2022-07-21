<?php

namespace Modules\Geo\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CityFactory extends Factory
{
    protected $model = \Modules\Geo\Models\City::class;

    public function definition()
    {
        return [
            'name' => $this->faker->city,
            'slug' => $this->faker->unique()->word(),
            'status' => 1,
            'is_default' => 2,
            'coordinate' => [
                'lat' => 123,
                'long' => 456,
            ]
        ];
    }
}

