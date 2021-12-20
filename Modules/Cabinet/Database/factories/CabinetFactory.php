<?php
namespace Modules\Cabinet\Database\factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Modules\Category\Models\Category;

class CabinetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Cabinet\Models\Cabinet::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'category_id' => Category::factory(),
            'image' => UploadedFile::fake()->image('test.png'),
            'full_description' => $this->faker->text,
            'status' => Status::getRandomValue(),
            'welcome_text' => $this->faker->text,
        ];
    }
}

