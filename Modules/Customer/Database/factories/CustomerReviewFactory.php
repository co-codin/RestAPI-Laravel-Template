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
            'post' => $this->faker->name(),
            'author' => $this->faker->name(),
            'type' => CustomerType::getRandomValue(),
            'video' => 'https://youtu.be/BcIMTGoXj_I',
            'review_file' => '/uploads/test.pdf',
            'is_home' => $this->faker->boolean,
            'comment' => '<p>' . $this->faker->text() . '</p>',
            'logo' => $imagePath . $this->faker->randomElement(["helix.png", "gemotest_lider.png", "invitro.png", "medi.png"]),
        ];
    }
}
