<?php

namespace Modules\Publication\Database\factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Publication\Models\Publication::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(4),
            'url' => $this->faker->url,
            'source' => $this->faker->words(2, true),
            'is_enabled' => $this->faker->boolean,
            'published_at' => $this->faker->date('d.m.Y'),
        ];
    }
}

