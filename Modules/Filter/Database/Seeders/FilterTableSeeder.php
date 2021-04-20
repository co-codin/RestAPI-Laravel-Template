<?php

namespace Modules\Filter\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Filter\Enums\FilterType;
use Modules\Filter\Models\Filter;

class FilterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
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
//                    'aggregationFormatter' => PriceAggregationFormatter::class,
//                    'searchFormatter' => PriceSearchFormatter::class,
//                    'tagFormatter' => PriceTagFormatter::class,
//                    'seoFormatter' => PriceSeoTagFormatter::class,
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
