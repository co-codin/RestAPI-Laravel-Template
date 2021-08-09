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
            'region_name' => $this->faker->word(4),
            'region_name_with_type' => $this->faker->word(4),
            'federal_district' => $this->faker->word(4),
            'iso' => $this->faker->unique()->word(4),

            'city_name' => $this->faker->word(4),
            'city_slug' => $this->faker->word(4),
            'status' => 1,

            'is_default' => 2,
            'coordinate' => [
                'lat' => 123,
                'long' => 456,
            ]
        ];
    }
}

