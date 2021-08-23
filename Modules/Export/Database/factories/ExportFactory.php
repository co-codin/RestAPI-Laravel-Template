<?php

namespace Modules\Export\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Brand\Models\Brand;
use Modules\Category\Models\Category;
use Modules\Export\Enum\ExportFrequency;
use Modules\Export\Enum\ExportType;
use Modules\Product\Enums\ProductVariationStock;
use Modules\Product\Models\Product;

class ExportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Export\Models\Export::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(4),
            'type' => 1,
            'filename' => 'test',
            'frequency' => 1,
            'parameters' => [
                'categories' => ['ids' => Category::factory()->count(3)->create()->pluck('id')->toArray(), 'selected' => $this->faker->boolean],
                'brands' => ['ids' => Brand::factory()->count(2)->create()->pluck('id')->toArray(), 'selected' => $this->faker->boolean],
                'products' => ['ids' => Product::factory()->count(5)->create()->pluck('id')->toArray(), 'selected' => $this->faker->boolean],
                'stock_type' => $this->faker->sentence(4),
                'in_stock' => ProductVariationStock::getRandomValue(),
                'short_description' => $this->faker->boolean,
                'price' => $this->faker->boolean,
            ]
        ];
    }
}

