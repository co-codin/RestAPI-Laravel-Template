<?php

namespace Modules\Customer\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Customer\Enums\CustomerType;
use Modules\Customer\Models\CustomerReview;

class CustomerReviewFactory extends Factory
{
    protected $model = CustomerReview::class;

    public function definition()
    {
        $imagePath = "/uploads/test/reviews/";

        return [
            'company_name' => $this->faker->name(),
            'position' => $this->faker->name(),
            'author' => $this->faker->name(),
            'type' => CustomerType::getRandomValue(),
            'video' => 'https://youtu.be/BcIMTGoXj_I',
            'is_in_home' => $this->faker->boolean,
            'comment' => '<p>' . $this->faker->text() . '</p>',
        ];
    }
}
