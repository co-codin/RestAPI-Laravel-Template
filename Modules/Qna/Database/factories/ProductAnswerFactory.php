<?php

namespace Modules\Qna\Database\factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Qna\Models\ProductAnswer;
use Modules\Qna\Models\ProductQuestion;

class ProductAnswerFactory extends Factory
{
    protected $model = ProductAnswer::class;

    public function definition()
    {
        return [
            'question_id' => ProductQuestion::inRandomOrder()->first()->id,
            'text' => $this->faker->sentence(10),
            'first_name' => $this->faker->name(),
            'last_name' => $this->faker->name(),
            'like' => $this->faker->numberBetween(0, 30),
            'dislike' => $this->faker->numberBetween(0, 30),
            'created_at' => $this->faker->dateTime(),
        ];
    }
}

