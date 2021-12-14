<?php

namespace Modules\Qna\Database\factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Qna\Models\Answer;
use Modules\Qna\Models\Question;

class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition()
    {
        return [
            'question_id' => Question::inRandomOrder()->first()->id,
            'text' => $this->faker->sentence(10),
            'name' => $this->faker->name(),
            'like' => $this->faker->numberBetween(0, 30),
            'dislike' => $this->faker->numberBetween(0, 30),
            'created_at' => $this->faker->dateTime(),
        ];
    }
}

