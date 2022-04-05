<?php

namespace Modules\Export\Database\factories;

use App\Models\FieldValue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Brand\Models\Brand;
use Modules\Category\Models\Category;
use Modules\Export\Enum\ExportFrequency;
use Modules\Export\Enum\ExportType;
use Modules\Product\Enums\Availability;
use Modules\Product\Models\Product;
use Modules\Export\Models\Export;

class ExportFactory extends Factory
{
    protected $model = Export::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(4),
            'type' => ExportType::getRandomValue(),
            'filename' => $this->faker->unique()->sentence(4) . '.xml',
            'frequency' => ExportFrequency::getRandomValue(),
            'filter' => [
                'category' => [
                    'ids' => Category::factory()->count(3)->create()->pluck('id')->toArray(),
                    'selected' => $this->faker->boolean,
                ],
                'brand' => [
                    'ids' => Brand::factory()->count(2)->create()->pluck('id')->toArray(),
                    'selected' => $this->faker->boolean,
                ],
                'product' => [
                    'ids' => Product::factory()->count(5)->create()->pluck('id')->toArray(),
                    'selected' => $this->faker->boolean,
                ],
                'stock_type' => [
                    'ids' => $this->faker->sentence(4),
                    'selected' => $this->faker->boolean,
                ],
                'availability' => [
                    'ids' => [Availability::getRandomValue()],
                    'selected' => $this->faker->boolean,
                ],
                'stock_type' => [
                    'ids' => FieldValue::factory()->count(2)->create()->pluck('id')->toArray(),
                    'selected' => $this->faker->boolean,
                ],
                'has_short_description' => $this->faker->boolean,
                'has_price' => $this->faker->boolean,
                'is_price_visible' => $this->faker->boolean,
            ]
        ];
    }
}

