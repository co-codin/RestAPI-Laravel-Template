<?php
namespace Modules\Geo\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RegionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Geo\Models\Region::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(4),
            'region_name_with_type' => $this->faker->word(4),
            'federal_district' => $this->faker->word(4),
            'iso' => $this->faker->unique()->word(4),
        ];
    }
}

