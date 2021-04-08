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
            'url' => $this->faker->sentence(4),
            'source' => $this->faker->sentence(4),
            'is_enabled' => $this->faker->boolean,
            'published_at' => Carbon::now()->format('d.m.Y'),
        ];
    }
}

