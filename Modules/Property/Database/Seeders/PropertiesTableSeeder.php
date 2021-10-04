<?php

namespace Modules\Property\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Modules\Property\Enums\PropertyType;
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
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['100 GB', '512 GB', '256 GB'],
                'description' => '',
            ],
            [
                'name' => 'Цвет',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['Красный', 'Желтый', 'Фиолетовый'],
                'description' => '',
            ],
            [
                'name' => 'Материал',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['Стекло', 'Железо', 'Керамика', 'Пластик'],
                'description' => '',
            ],
            [
                'name' => 'Класс аппарата',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['Профессиональный', 'Базовый', 'Экспертный'],
                'description' => '',
            ],
            [
                'name' => 'Длина',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['100', '200', '300', '400'],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Вес',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['200', '300', '400'],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Объем',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['100', '134', '5'],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Ширина',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['155', '123', '100'],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Дисплей',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['17', '15', '20'],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Диаметр',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => [100, 156, 213],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Разрешение экрана',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['1024x768', '1920x1080', '2560x1440'],
                'description' => '',
            ],
            [
                'name' => 'Камера',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['20', '24', '23'],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Количество камер',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => [1, 2, 4],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Версия ПО',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['v 123', 'v. 213', 'c6665'],
                'description' => '',
            ],
            [
                'name' => 'Предустановленная ОС',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['Windows', 'Mac OS', 'Linux'],
                'description' => '',
            ],
            [
                'name' => 'Объектив',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['Зеркальный', 'Другой'],
                'description' => '',
            ],
            [
                'name' => 'Угол обзора',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => [170, 280],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Материал корпуса',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['Пластик', 'Глина', 'Аллюминий', 'Олово'],
                'description' => '',
            ],
            [
                'name' => 'Тип экрана',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['IPS', 'TFT', 'VA', 'PLS'],
                'description' => '',
            ],
            [
                'name' => 'Размер изображения',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['1000x2000', '20000x49444'],
                'description' => '',
            ],
            [
                'name' => 'Количество основных камер',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => [1, 2, 4, 3],
                'description' => '',
            ],
            [
                'name' => 'Разъем для наушников',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['3.5', '2.5'],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Стандарт связи',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['GSM', 'EDGE', 'GPRS', 'LTE'],
                'description' => '',
            ],
            [
                'name' => 'Процессор',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => ['Intel Core i5', 'Intel Core i6'],
                'description' => '',
            ],
            [
                'name' => 'Оперативная память',
                'type' => PropertyType::TextInput,
                'rules' => 'sometimes|nullable|string',
                'values' => [32, 64, 128, 256],
                'is_numeric' => true,
                'description' => '',
            ],
            [
                'name' => 'Оборудование для борьбы с последствиями COVID-19',
                'type' => PropertyType::CheckBox,
                'rules' => 'sometimes|nullable|boolean',
                'values' => [true, false],
                'description' => '',
            ],
        ];
    }
}
