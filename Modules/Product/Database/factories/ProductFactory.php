<?php

namespace Modules\Product\Database\factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Modules\Brand\Models\Brand;
use Modules\Product\Enums\ProductType;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Product\Models\Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
//            'type' => ProductType::getRandomValue(),
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'brand_id' => Brand::factory(),
            'status' => Status::ACTIVE,
            'image' => $this->faker->imageUrl(),
            'is_in_home' => $this->faker->boolean,
            'warranty' => $this->faker->randomElement([12, 24, 26, 48, 60]),
        ];
    }
}

