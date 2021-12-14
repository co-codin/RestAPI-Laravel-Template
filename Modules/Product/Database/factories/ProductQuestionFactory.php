<?php

namespace Modules\Product\Database\factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Models\Product;
use Modules\Product\Enums\ProductQuestionStatus;
use Modules\Product\Models\ProductQuestion;

class ProductQuestionFactory extends Factory
{
    protected $model = ProductQuestion::class;

    public function definition()
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'client_id' => Client::inRandomOrder()->first()->id,
            'status' => ProductQuestionStatus::getRandomValue(),
            'text' => $this->faker->sentence(10),
            'created_at' => $this->faker->dateTime(),
        ];
    }
}

