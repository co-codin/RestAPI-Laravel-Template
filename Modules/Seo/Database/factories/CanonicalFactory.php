<?php

namespace Modules\Seo\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Seo\Models\Canonical;

class CanonicalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Canonical::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'url' => $this->faker->url,
            'canonical' => $this->faker->url,
        ];
    }
}

