<?php

namespace Modules\Property\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Modules\Property\Models\Property;

class PropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::properties() as $property) {
            Property::query()->create(Arr::except($property, ['values', 'rules']));
        }
    }

    public static function properties()
    {
        return [
            [
                'name' => 'Объем памяти',
                'rules' => 'sometimes|nullable|string',
                'values' => ['100 GB', '512 GB', '256 GB'],
                'description' => '',
            ],
            [
                'name' => 'Цвет',
                'rules' => 'sometimes|nullable|string',
                'values' => ['Красный', 'Желтый', 'Фиолетовый'],
                'description' => '',
            ],
            [
                'name' => 'Материал',
                'rules' => 'sometimes|nullable|string',
                'values' => ['Стекло', 'Железо', 'Керамика', 'Пластик'],
                'description' => '',
            ],
            [
                'name' => 'Класс аппарата',
                'rules' => 'sometimes|nullable|string',
                'values' => ['Профессиональный', 'Базовый', 'Экспертный'],
                'description' => '',
            ],
            [
                'name' => 'Длина',
                'rules' => 'sometimes|nullable|string',
                'values' => ['100', '200', '300', '400'],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Вес',
                'rules' => 'sometimes|nullable|string',
                'values' => ['200', '300', '400'],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Объем',
                'rules' => 'sometimes|nullable|string',
                'values' => ['100', '134', '5'],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Ширина',
                'rules' => 'sometimes|nullable|string',
                'values' => ['155', '123', '100'],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Дисплей',
                'rules' => 'sometimes|nullable|string',
                'values' => ['17', '15', '20'],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Диаметр',
                'rules' => 'sometimes|nullable|string',
                'values' => [100, 156, 213],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Разрешение экрана',
                'rules' => 'sometimes|nullable|string',
                'values' => ['1024x768', '1920x1080', '2560x1440'],
                'description' => '',
            ],
            [
                'name' => 'Камера',
                'rules' => 'sometimes|nullable|string',
                'values' => ['20', '24', '23'],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Количество камер',
                'rules' => 'sometimes|nullable|string',
                'values' => [1, 2, 4],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Версия ПО',
                'rules' => 'sometimes|nullable|string',
                'values' => ['v 123', 'v. 213', 'c6665'],
                'description' => '',
            ],
            [
                'name' => 'Предустановленная ОС',
                'rules' => 'sometimes|nullable|string',
                'values' => ['Windows', 'Mac OS', 'Linux'],
                'description' => '',
            ],
            [
                'name' => 'Объектив',
                'rules' => 'sometimes|nullable|string',
                'values' => ['Зеркальный', 'Другой'],
                'description' => '',
            ],
            [
                'name' => 'Угол обзора',
                'rules' => 'sometimes|nullable|string',
                'values' => [170, 280],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Материал корпуса',
                'rules' => 'sometimes|nullable|string',
                'values' => ['Пластик', 'Глина', 'Аллюминий', 'Олово'],
                'description' => '',
            ],
            [
                'name' => 'Тип экрана',
                'rules' => 'sometimes|nullable|string',
                'values' => ['IPS', 'TFT', 'VA', 'PLS'],
                'description' => '',
            ],
            [
                'name' => 'Размер изображения',
                'rules' => 'sometimes|nullable|string',
                'values' => ['1000x2000', '20000x49444'],
                'description' => '',
            ],
            [
                'name' => 'Количество основных камер',
                'rules' => 'sometimes|nullable|string',
                'values' => [1, 2, 4, 3],
                'description' => '',
            ],
            [
                'name' => 'Разъем для наушников',
                'rules' => 'sometimes|nullable|string',
                'values' => ['3.5', '2.5'],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Стандарт связи',
                'rules' => 'sometimes|nullable|string',
                'values' => ['GSM', 'EDGE', 'GPRS', 'LTE'],
                'description' => '',
            ],
            [
                'name' => 'Процессор',
                'rules' => 'sometimes|nullable|string',
                'values' => ['Intel Core i5', 'Intel Core i6'],
                'description' => '',
            ],
            [
                'name' => 'Оперативная память',
                'rules' => 'sometimes|nullable|string',
                'values' => [32, 64, 128, 256],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Оборудование для борьбы с последствиями COVID-19',
                'rules' => 'sometimes|nullable|boolean',
                'values' => [true, false],
                'description' => '',
            ],
        ];
    }
}
