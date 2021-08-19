<?php

namespace Modules\Product\Database\factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Brand\Models\Brand;

class ProductFactory extends Factory
{
    protected $model = \Modules\Product\Models\Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'brand_id' => Brand::factory(),
            'status' => Status::ACTIVE,
            'image' => $this->faker->imageUrl(),
            'is_in_home' => $this->faker->boolean,
            'warranty' => $this->faker->randomElement([12, 24, 26, 48, 60]),
            'short_description' => $this->faker->text(200),
            'full_description' => $this->faker->text(),
        ];
    }
}

