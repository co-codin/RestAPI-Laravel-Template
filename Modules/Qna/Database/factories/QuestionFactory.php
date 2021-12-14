<?php

namespace Modules\Qna\Database\factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Models\Product;
use Modules\Qna\Enums\QuestionStatus;
use Modules\Qna\Models\Question;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'client_id' => Client::inRandomOrder()->first()->id,
            'status' => QuestionStatus::getRandomValue(),
            'text' => $this->faker->sentence(10),
            'created_at' => $this->faker->dateTime(),
        ];
    }
}

