<?php


namespace App\Console\Commands\Migration\Enums;


use App\Enums\BaseEnum;

final class OldPropertyType extends BaseEnum
{
    const Mark = 1;
    const TextInput = 2;
    const Book = 4;
    const Entity = 5;
    const Enum = 6;

    public static function fields()
    {
        return [
            self::Book => [
                [
                    'name' => 'book_id',
                    'label' => 'Справочник',
                    'description' => 'Введите ID справочника',
                    'type' => 'textInput',
                    'rules' => 'required|exists:books,id',
                ],
                [
                    'name' => 'multiple',
                    'label' => 'Множественный выбор',
                    'description' => 'Разрешить множественный выбор',
                    'type' => 'checkBox',
                    'rules' => 'sometimes|nullable|boolean'
                ],
            ],

            self::Enum => [
                [
                    'name' => 'enum',
                    'label' => 'Класс Enum',
                    'description' => 'Выберите полный путь к классу Enum',
                    'type' => 'textInput',
                    'rules' => 'required|string|class_exists',
                ],
            ],

            self::Entity => [
                [
                    'name' => 'repository',
                    'label' => 'Класс репозитория',
                    'description' => 'Выберите класс репозитория',
                    'type' => 'textInput',
                    'rules' => 'required|string|class_exists',
                ],
                [
                    'name' => 'primaryKey',
                    'label' => 'Первичный ключ',
                    'description' => 'Выберите первичный ключ репозитория',
                    'type' => 'textInput',
                    'rules' => 'sometimes|nullable|string',
                ],
                [
                    'name' => 'titleKey',
                    'label' => 'Ключ с описанием',
                    'description' => 'Введите описание ключа',
                    'type' => 'textInput',
                    'rules' => 'sometimes|nullable|string',
                ],
            ],
        ];
    }
}
