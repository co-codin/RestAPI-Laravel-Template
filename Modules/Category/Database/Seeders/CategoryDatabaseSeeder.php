<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Models\Category;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'УЗИ',
                'product_name' => 'УЗИ аппарат',
                'image' => '/uploads/test/categories/uzi.png',
                'children' => [
                    [
                        'name' => 'Кардиологические',
                        'product_name' => 'УЗИ аппарат',
                    ],
                    [
                        'name' => 'Гинекологические',
                        'product_name' => 'УЗИ аппарат',
                    ],
                    [
                        'name' => 'Общие',
                        'product_name' => 'УЗИ аппарат',
                    ],
                ],
            ],
            [
                'name' => 'Гинекология',
                'image' => '/uploads/test/categories/ginekolog.png',
                'children' => [
                    [
                        'name' => 'Кольпоскопы',
                        'product_name' => 'Кольпоскоп',
                    ],
                    [
                        'name' => 'Комбайны',
                        'product_name' => 'Комбайн',
                    ],
                    [
                        'name' => 'Кресла',
                        'product_name' => 'Гинекологическое кресло',
                    ],
                ],
            ],
            [
                'name' => 'Эндоскопия',
                'product_name' => 'УЗИ аппарат',
                'image' => '/uploads/test/categories/endoskop.png',
                'children' => [
                    [
                        'name' => 'Видеосистемы',
                        'product_name' => 'Видеосистема',
                    ],
                    [
                        'name' => 'Видеопроцессоры',
                        'product_name' => 'Видеопроцессор',
                    ],
                    [
                        'name' => 'Видеоэндоскопы',
                        'product_name' => 'Видеоэндоскоп',
                    ],
                    [
                        'name' => 'Фиброскопы',
                        'product_name' => 'Фиброскоп',
                    ],
                    [
                        'name' => 'Мониторы',
                        'product_name' => 'Монитор',
                    ],
                    [
                        'name' => 'Принадлежности',
                    ],
                    [
                        'name' => 'Инструментарий',
                    ],
                ],
            ],
            [
                'name' => 'Стоматология',
                'image' => '/uploads/test/categories/stom.png',
                'children' => [
                    [
                        'name' => 'Стоматологические установки',
                    ],
                    [
                        'name' => 'Рентгены и визиографы',
                        'product_name' => 'Визиограф',
                    ],
                    [
                        'name' => 'Автоклавы и стерилизаторы',
                        'product_name' => 'Автоклав',
                    ],
                    [
                        'name' => 'Принадлежности',
                    ],
                ],
            ],
            [
                'name' => 'Томография',
                'image' => '/uploads/test/categories/tomogr.png',
                'children' => [
                    [
                        'name' => 'МРТ',
                        'product_name' => 'Аппарат МРТ',
                    ],
                    [
                        'name' => 'КТ',
                        'product_name' => 'Аппарат КТ',
                    ],
                    [
                        'name' => 'ПЭТ',
                        'product_name' => 'Аппарат ПЭТ',
                    ],
                ],
            ],
            [
                'name' => 'ЛОР',
                'image' => '/uploads/test/categories/lor.png',
                'children' => [
                    [
                        'name' => 'Лор-комбайны',
                        'product_name' => 'Лор-комбайн',
                    ],
                    [
                        'name' => 'Аудиометры / Тимпанометры',
                        'product_name' => 'Аудиометр',
                    ],
                    [
                        'name' => 'Системы визуализации',
                        'product_name' => 'Система визуализации',
                    ],
                    [
                        'name' => 'Микроскопы',
                        'product_name' => 'Микроскоп',
                    ],
                    [
                        'name' => 'Процедурные аппараты',
                    ],
                    [
                        'name' => 'Кресла',
                        'product_name' => 'Лор кресло',
                    ],
                    [
                        'name' => 'Другое',
                    ],
                ],
            ],
            [
                'name' => 'Рентгенология',
                'image' => '/uploads/test/categories/rentgen.png',
                'children' => [
                    [
                        'name' => 'Стационарные рентгеновские аппараты',
                        'product_name' => 'Рентген',
                    ],
                    [
                        'name' => 'Палатные',
                        'product_name' => 'Рентген',
                    ],
                    [
                        'name' => 'Флюорографы',
                        'product_name' => 'Рентген',
                    ],
                    [
                        'name' => 'Ангиографы и С-дуги',
                        'product_name' => 'Ангиограф',
                    ],
                    [
                        'name' => 'Маммографы',
                        'product_name' => 'Маммограф',
                    ],
                ],
            ],
            [
                'name' => 'Реанимация',
                'image' => '/uploads/test/categories/reanimaci.png',
                'children' => [
                    [
                        'name' => 'Наркозники',
                        'product_name' => 'Наркозник',
                    ],
                    [
                        'name' => 'Аппараты ИВЛ',
                        'product_name' => 'Аппарат ИВЛ',
                    ],
                    [
                        'name' => 'Мониторы',
                        'product_name' => 'Монитор',
                    ],
                    [
                        'name' => 'Дефибрилляторы',
                        'product_name' => 'Дефибриллятор',
                    ],
                    [
                        'name' => 'Инкубаторы',
                        'product_name' => 'Инкубатор',
                    ],
                ],
            ],
            [
                'name' => 'Косметология',
                'image' => '/uploads/test/categories/cosmetology.jpg',
            ],
            [
                'name' => 'Хирургия',
                'image' => '/uploads/test/categories/hirurg.jpg',
            ],
            [
                'name' => 'Лаборатория',
                'image' => '/uploads/test/categories/laborat.jpg',
            ],
            [
                'name' => 'Реабилитация',
                'image' => '/uploads/test/categories/reability.jpg',
            ],
        ];

        foreach($categories as $category)
        {
            $category['is_in_home'] = true;

            Category::create($category);
        }
    }
}
