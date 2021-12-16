<?php

namespace Database\Factories;


use App\Enums\Subject;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->name(),
            'last_name' => $this->faker->lastName(),
            'subject' => Subject::getRandomValue(),
            'phone' => $this->faker->phoneNumber(),
        ];
    }
}

