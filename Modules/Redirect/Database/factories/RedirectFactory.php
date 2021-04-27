<?php
namespace Modules\Redirect\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RedirectFactory extends Factory
{
    protected $model = \Modules\Redirect\Models\Redirect::class;

    public function definition()
    {
        return [
            'source' => $this->faker->url,
            'destination' => $this->faker->url,
            'code' => $this->faker->randomElement([301, 302]),
        ];
    }
}

