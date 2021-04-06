<?php
namespace Modules\Seo\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SeoRuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Seo\Models\SeoRule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(4),
            'url' => '/admin/achievements'
        ];
    }
}

