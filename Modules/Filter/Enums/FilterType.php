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
            ],
            self::CheckMarkList => [
                [
                    'name' => 'storage',
                    'label' => 'Хранилище',
                    'description' => '',
                    'type' => 'textInput',
                ],
            ],
            self::CheckMark => [
                [
                    'name' => 'value',
                    'label' => 'Значение для поиска',
                    'description' => 'Введите значение для поиска',
                    'type' => 'textInput',
                ],
            ],
        ];
    }
}
