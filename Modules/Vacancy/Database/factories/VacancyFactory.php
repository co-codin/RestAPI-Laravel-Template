<?php
namespace Modules\Vacancy\Database\factories;

use App\Enums\Status;
use Modules\Vacancy\Models\Vacancy;
use Illuminate\Database\Eloquent\Factories\Factory;

class VacancyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vacancy::class;

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
            'status' => Status::ACTIVE,
            'duty' => $this->faker->word,
            'requirement' => $this->faker->word,
            'condition' => $this->faker->word,
        ];
    }
}

