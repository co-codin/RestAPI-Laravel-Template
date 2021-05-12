<?php

namespace Modules\Seo\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Seo\Models\CanonicalEntity;

class CanonicalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CanonicalEntity::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'url' => '/achievements',
            'canonical' => $this->faker->url,
        ];
    }
}

