<?php

namespace Modules\Filter\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Filter\Enums\FilterType;
use Modules\Filter\Models\Filter;

class FiltersTableSeeder extends Seeder
{
    public function run()
    {
        $filters = [
            [
                'name' => 'Производитель',
                'slug' => 'brand',
                'type' => FilterType::CheckMarkList,
                'is_enabled' => true,
            ],
            [
                'name' => 'Тип',
                'slug' => 'type',
                'type' => FilterType::CheckMarkList,
                'is_enabled' => true,
            ],
            [
                'name' => 'Цена',
                'slug' => 'price',
                'type' => FilterType::Slider,
                'is_enabled' => true,
                'options' => [
                    'seoTagLabel' => 'с ценой от <from> и до <to> руб.'
                ],
            ],
            [
                'name' => 'В наличии',
                'slug' => 'instock',
                'type' => FilterType::CheckMark,
                'is_enabled' => true,
            ],
            [
                'name' => 'По акции',
                'slug' => 'hot',
                'type' => FilterType::CheckMark,
                'is_enabled' => true,
            ],
        ];

        foreach ($filters as $filter)
        {
            Filter::create($filter);
        }
    }
}
