<?php
namespace Modules\Geo\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\City;
use Modules\Product\Models\Product;

class SoldProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Geo\Models\SoldProduct::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'product_id' => Product::factory(),
            'city_id' => City::factory(),
            'type' => $this->faker->randomDigit(),
            'is_enabled' => $this->faker->boolean,
        ];
    }
}

