<?php

namespace Modules\Filter\Enums;

use App\Enums\BaseEnum;

/**
 * @method static static CheckMarkList()
 * @method static static Slider()
 * @method static static CheckMark()
 */
final class FilterType extends BaseEnum
{
    const CheckMarkList = 1;
    const Slider = 2;
    const CheckMark = 3;

    public static function fields()
    {
        return [
            self::Slider => [
                [
                    'name' => 'step',
                    'label' => 'Шаг',
                    'description' => 'Шаг слайдера',
                    'type' => 'textInput',
                ],
                [
                    'name' => 'aggregationFormatter',
                    'label' => 'Aggregation Formatter Class',
                    'description' => 'Кастомный класс aggregation',
                    'type' => 'textInput',
                ],
                [
                    'name' => 'searchFormatter',
                    'label' => 'Search Formatter Class',
                    'description' => 'Кастомный класс search',
                    'type' => 'textInput',
                ],
                [
                    'name' => 'tagFormatter',
                    'label' => 'Tag Formatter Class',
                    'description' => 'Кастомный класс tag',
                    'type' => 'textInput',
                ],
                [
                    'name' => 'seoFormatter',
                    'label' => 'Seo Formatter Class',
                    'description' => 'Кастомный класс seo formatter',
                    'type' => 'textInput',
                ],
                [
                    'name' => 'seoTagLabel',
                    'label' => 'Seo метка',
                    'description' => 'Введите SEO метку. Поддерживает переменные <from> и <to>',
                    'type' => 'textInput',
                    'rules' => [
                        'required',
                    ],
                ],
            ],
            self::CheckMarkList => [
                [
                    'name' => 'seoTagLabels',
                    'label' => 'Метки',
                    'description' => 'Пропишите метки',
                    'type' => 'repeater',
                    'fields' => [
                        [
                            'type' => 'textInput',
                            'name' => 'key',
                            'label' => 'Ключ',
                            'description' => 'Пропишите ключ',
                        ],
                        [
                            'type' => 'textInput',
                            'name' => 'value',
                            'label' => 'Значение',
                            'description' => 'Пропишите значение ключа',
                        ],
                    ]
                ],
                [
                    'name' => 'seoPrefix',
                    'label' => 'SEO префикс',
                    'description' => 'SEO префикс при генерации h1, title, description',
                    'type' => 'textInput',
                    'rules' => [
                        'sometimes', 'nullable', 'string', 'max:255',
                    ],
                ]
            ],
            self::CheckMark => [
                [
                    'name' => 'seoTagLabel',
                    'label' => 'Seo метка',
                    'description' => 'Введите SEO метку',
                    'type' => 'textInput',
                ],
                [
                    'name' => 'filter_value',
                    'label' => 'Значение для поиска',
                    'description' => 'Введите значение для поиска',
                    'type' => 'textInput',
                ],
            ]
        ];
    }
}
