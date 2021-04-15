<?php

namespace Modules\Brand\Database\factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Modules\Brand\Models\Brand;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'website' => $this->faker->url,
            'full_description' => $this->faker->text,
            'image' => UploadedFile::fake()->image('test.png'),
            'short_description' => $this->faker->sentence(10),
            'status' => Status::getRandomValue(),
            'is_in_home' => $this->faker->boolean,
            'position' => $this->faker->randomDigit,
            'country' => $this->faker->country,
        ];
    }
}

