<?php
namespace Modules\Redirect\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RedirectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Redirect\Models\Redirect::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'old_url' => $this->faker->url,
            'new_url' => $this->faker->url,
        ];
    }
}

