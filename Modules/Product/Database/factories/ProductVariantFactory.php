<?php

namespace Modules\Product\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Currency\Models\Currency;
use Modules\Product\Models\Product;

class ProductVariantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Product\Models\ProductVariant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'name' => $this->faker->word,
            'price' => $this->faker->numberBetween(1000, 9000),
            'previous_price' => $this->faker->numberBetween(1000, 9000),
            'is_price_visible' => $this->faker->boolean,
            'is_enabled' => $this->faker->boolean,
            'availability' => 1,
            'currency_id' => count(Currency::all()) ? Currency::inRandomOrder()->first() : Currency::factory(),
        ];
    }
}

