<?php

namespace Modules\Faq\Database\factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Faq\Models\QuestionCategory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Faq\Models\Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question_category_id' => QuestionCategory::factory(),
            'question' => $this->faker->sentence(4),
            'answer' => $this->faker->sentence(4),
            'status' => Status::getRandomValue()
        ];
    }
}

