<?php

namespace Modules\Review\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Review\Enums\ProductReviewExperience;
use Modules\Review\Enums\ProductReviewStatus;
use Modules\Review\Models\ProductReview;

class ProductReviewFactory extends Factory
{
    protected $model = ProductReview::class;

    public function definition()
    {
        $experiences = ProductReviewExperience::getValues();

        return [
            'client_id' => $this->faker->randomDigit(),
            'experience' => $this->faker->numberBetween(min($experiences),max($experiences)),
            'short_description' => $this->faker->sentence(10),
            'advantages' => $this->faker->sentence(),
            'disadvantages' => $this->faker->sentence(),
            'comment' => $this->faker->sentence(10),
            'status' => ProductReviewStatus::getRandomValue(),
            'is_confirmed' => $this->faker->numberBetween(0,1),
        ];
    }
}

