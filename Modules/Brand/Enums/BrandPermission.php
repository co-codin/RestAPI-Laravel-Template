<?php

namespace Modules\Brand\Enums;

use Modules\Role\Contracts\PermissionEnum;

class BrandPermission implements PermissionEnum
{
    const CREATE_BRANDS = 'create brands';
    const VIEW_BRANDS = 'view brands';
    const EDIT_BRANDS = 'edit brands';
    const DELETE_BRANDS = 'delete brands';

    public static function module(): string
    {
        return 'Производители';
    }

    public static function descriptions() : array
    {
        return [
            static::CREATE_BRANDS => 'Добавление производителей',
            static::VIEW_BRANDS => 'Просмотр производителей',
            static::EDIT_BRANDS => 'Редактирование производителей',
            static::DELETE_BRANDS => 'Удаление производителей',
        ];
    }
}
