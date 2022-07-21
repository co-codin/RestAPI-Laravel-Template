<?php

namespace Modules\Publication\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

class PublicationFactory extends Factory
{
    protected $model = \Modules\Publication\Models\Publication::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(4),
            'url' => $this->faker->unique()->url,
            'source' => $this->faker->words(2, true),
            'logo' => UploadedFile::fake()->image('test_logo.png'),
            'is_enabled' => $this->faker->boolean,
            'published_at' => $this->faker->date(),
        ];
    }
}

