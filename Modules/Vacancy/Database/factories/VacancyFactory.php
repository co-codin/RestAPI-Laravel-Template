<?php
namespace Modules\Vacancy\Database\factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class VacancyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Vacancy\Models\Vacancy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'short_description' => $this->faker->sentence(10),
            'full_description' => $this->faker->sentence(30),
            'status' => Status::ACTIVE,
        ];
    }
}

