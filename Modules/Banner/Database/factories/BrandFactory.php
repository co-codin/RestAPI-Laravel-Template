<?php

namespace Modules\Banner\Database\factories;

use App\Enums\Status;
use App\Models\FieldValue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Banner\Models\Banner;

class BannerFactory extends Factory
{
    protected $model = Banner::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'url' => $this->faker->url,
        ];
    }
}

