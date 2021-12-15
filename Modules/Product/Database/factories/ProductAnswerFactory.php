<?php

namespace Modules\Product\Database\factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Models\ProductAnswer;
use Modules\Product\Models\ProductQuestion;

class ProductAnswerFactory extends Factory
{
    protected $model = ProductAnswer::class;

    public function definition()
    {
        return [
            'product_question_id' => ProductQuestion::inRandomOrder()->first()->id,
            'text' => $this->faker->sentence(10),
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'like' => $this->faker->numberBetween(0, 30),
            'dislike' => $this->faker->numberBetween(0, 30),
            'created_at' => $this->faker->dateTime(),
        ];
    }
}

