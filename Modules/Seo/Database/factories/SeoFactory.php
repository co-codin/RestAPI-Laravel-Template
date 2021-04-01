<?php

namespace Modules\Seo\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Seo\Enums\SeoType;
use Modules\Seo\Models\SeoRule;

class SeoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Seo\Models\Seo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'seoable_type' => get_class($seoRule = SeoRule::factory()->create()),
            'seoable_id' => $seoRule->id,
            'is_enabled' => $this->faker->boolean,
            'description' => $this->faker->sentence(10),
            'h1' => $this->faker->sentence(4),
            'meta_tags' => [
                [
                    'content' => $this->faker->sentence(10)
                ]
            ],
            'type' => SeoType::getRandomValue(),
        ];
    }
}

