<?php

namespace Modules\Product\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductAnalog;

class ProductAnalogFactory extends Factory
{
    protected $model = ProductAnalog::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'analog_id' => Product::factory(),
        ];
    }
}

