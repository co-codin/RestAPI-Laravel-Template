<?php
namespace Modules\Contact\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Contact\Models\Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->word,
            'last_name' => $this->faker->word,
            'job_position' => $this->faker->word,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'photo' => $this->faker->imageUrl(),
            'is_enabled' => $this->faker->boolean,
        ];
    }
}

