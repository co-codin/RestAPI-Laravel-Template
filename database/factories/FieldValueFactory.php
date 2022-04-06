<?php

namespace Database\Factories;

use App\Models\FieldValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class FieldValueFactory extends Factory
{
    protected $model = FieldValue::class;

    public function definition()
    {
        return [
            'value' => $this->faker->sentence(4),
        ];
    }
}
