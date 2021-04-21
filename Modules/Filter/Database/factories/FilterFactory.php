<?php

namespace Modules\Filter\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Modules\Category\Models\Category;
use Modules\Filter\Enums\FilterType;
use Modules\Property\Models\Property;

class FilterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Filter\Models\Filter::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $data = [
            'name' => $this->faker->name,
            'slug' => $this->faker->word,
            'property_id' => Property::factory(),
            'type' => $type = FilterType::getRandomValue(),
            'category_id' => Category::factory(),
            'is_enabled' => $this->faker->boolean,
            'is_default' => $this->faker->boolean,
            'description' => $this->faker->sentence(10),
        ];

        $fields = Arr::get(FilterType::fields(), $type);

        foreach ($fields as $item) {
            if($item['rules'] ?? null) {
                $data["options"][$item['name']] = $this->faker->word;
            }
        }

        return $data;
    }
}

