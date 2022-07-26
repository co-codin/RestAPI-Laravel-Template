<?php

namespace Modules\Property\Enums;


use Modules\Role\Contracts\PermissionEnum;

class PropertyPermission implements PermissionEnum
{
    const CREATE_PROPERTIES = 'create properties';
    const VIEW_PROPERTIES = 'view properties';
    const EDIT_PROPERTIES = 'edit properties';
    const DELETE_PROPERTIES = 'delete properties';

    public static function module(): string
    {
        return 'Характеристики товара';
    }

    public static function descriptions() : array
    {
        return [
            static::CREATE_PROPERTIES => 'Добавление характиристик',
            static::VIEW_PROPERTIES => 'Просмотр характиристик',
            static::EDIT_PROPERTIES => 'Редактирование характиристик',
            static::DELETE_PROPERTIES => 'Удаление характиристик',
        ];
    }
}
