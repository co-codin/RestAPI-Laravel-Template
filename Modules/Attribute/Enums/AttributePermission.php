<?php

namespace Modules\Attribute\Enums;

use Modules\Role\Contracts\PermissionEnum;

class AttributePermission implements PermissionEnum
{
    const CREATE_ATTRIBUTES = 'create attributes';
    const VIEW_ATTRIBUTES = 'view attributes';
    const EDIT_ATTRIBUTES = 'edit attributes';
    const DELETE_ATTRIBUTES = 'delete attributes';
    const SORT_ATTRIBUTES = 'sort attributes';

    public static function module(): string
    {
        return 'Атрибуты';
    }

    public static function descriptions() : array
    {
        return [
            self::CREATE_ATTRIBUTES => 'Добавление атрибутов',
            self::VIEW_ATTRIBUTES => 'Просмотр атрибутов',
            self::EDIT_ATTRIBUTES => 'Редактирование атрибутов',
            self::DELETE_ATTRIBUTES => 'Удаление атрибутов',
            self::SORT_ATTRIBUTES => 'Сортировка атрибутов',
        ];
    }
}
