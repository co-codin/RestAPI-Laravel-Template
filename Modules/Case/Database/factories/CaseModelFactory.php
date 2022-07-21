<?php
namespace Modules\Case\Database\factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Geo\Models\City;

class CaseModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Case\Models\CaseModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'city_id' => City::factory(),
            'name' => $this->faker->word,
            'slug' => $this->faker->unique()->slug(),
            'short_description' => $this->faker->sentence,
            'full_description' => $this->faker->sentence,
            'image' => '/uploads/test/cases/' . $this->faker->randomElement([1, 2]) . '.jpg',
            'published_at' => $this->faker->word,
            'status' => Status::getRandomValue(),
            'summary' => $this->faker->sentence,
        ];
    }
}

