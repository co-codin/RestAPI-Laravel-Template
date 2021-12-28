<?php

namespace Modules\Product\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Currency\Models\Currency;
use Modules\Product\Enums\Availability;
use Modules\Product\Enums\SupplierEnum;
use Modules\Product\Models\ProductVariation;
use Modules\Product\Models\VariationLink;

class VariationLinkFactory extends Factory
{
    protected $model = VariationLink::class;

    public function definition()
    {
        return [
            'product_variation_id' => ProductVariation::factory(),
            'supplier' => SupplierEnum::getRandomValue(),
            'key' => $this->faker->url(),
            'is_default' => false,
            'check' => [
                ['element' => $this->faker->randomNumber(), 'value' => $this->faker->sentence],
                ['element' => $this->faker->randomNumber(), 'value' => $this->faker->sentence],
            ],
            'currency_id' => Currency::factory(),
            'price' => $this->faker->numberBetween(12312, 9812302),
            'availability' => Availability::getRandomValue(),
            'info_updated_at' => $this->faker->dateTime(),
        ];
    }
}

