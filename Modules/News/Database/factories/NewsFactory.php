<?php
namespace Modules\News\Database\factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\News\Models\News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'short_description' => $this->faker->sentence(10),
            'full_description' => $this->faker->sentence(30),
            'status' => Status::getRandomValue(),
            'in_home' => $this->faker->boolean,
            'image' => '/uploads/test/news/news' . $this->faker->randomElement([1, 2]) . '.jpg',
            'published_at' => $this->faker->date(),
        ];
    }
}

