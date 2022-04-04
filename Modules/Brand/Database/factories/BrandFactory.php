<?php

namespace Modules\Brand\Database\factories;

use App\Enums\Status;
use App\Models\FieldValue;
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
            'short_description' => $this->faker->sentence(10),
            'image' => $this->faker->imageUrl(),
            'status' => Status::getRandomValue(),
            'is_in_home' => $this->faker->boolean,
            'position' => $this->faker->randomDigit,
            'country_id' => FieldValue::factory()
        ];
    }
}

