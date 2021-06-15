<?php

namespace Modules\Export\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Export\Enum\ExportType;

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
            'name' => $this->faker->name,
            'type' => ExportType::getRandomValue(),
            'filename' => $this->faker->name,
            'frequency' => $this->faker->randomDigitNotNull,
            'parameters' => json_encode([
                'categories' => true,
                'brands' => false,
                'variations' => true,
            ])
        ];
    }
}

