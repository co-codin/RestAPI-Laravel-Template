<?php

namespace Modules\Geo\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\City;

class OrderPointFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Geo\Models\OrderPoint::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'city_id' => City::factory(),
            'name' => $this->faker->word(4),
            'address' => $this->faker->address,
            'coordinate' => [
                'lat' => 123,
                'long' => 456,
            ],
            'type' => 1,
            'status' => 1,
        ];
    }
}

