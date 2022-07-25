<?php


namespace App\Enums;


use Modules\Role\Contracts\PermissionEnum;

final class FieldValuePermission implements PermissionEnum
{
    const VIEW_FIELD_VALUES = 'view field values';

    const CREATE_FIELD_VALUES = 'create field values';

    const EDIT_FIELD_VALUES = 'edit field values';

    const DELETE_FIELD_VALUES = 'delete field values';

    public static function descriptions(): array
    {
        return [
            self::VIEW_FIELD_VALUES => 'Просмотр значений характеристик',
            self::CREATE_FIELD_VALUES => 'Создание значений характеристик',
            self::EDIT_FIELD_VALUES => 'Редактирование значений характеристик',
            self::DELETE_FIELD_VALUES => 'Удаление значений характеристик',
        ];
    }
}
