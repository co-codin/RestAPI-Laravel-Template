<?php
namespace Modules\Case\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\City;

class CaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Case\Models\CaseModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'city_id' => City::factory(),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'image' => '/uploads/test/cases/' . $this->faker->randomElement([1, 2]) . '.jpg',
            'published_at' => $this->faker->date(),
            'is_enabled' => $this->faker->boolean,
        ];
    }
}

