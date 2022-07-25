<?php

namespace Modules\Category\Enums;


use Modules\Role\Contracts\PermissionEnum;

class CategoryPermission implements PermissionEnum
{
    const CREATE_CATEGORIES = 'create categories';
    const VIEW_CATEGORIES = 'view categories';
    const EDIT_CATEGORIES = 'edit categories';
    const DELETE_CATEGORIES = 'delete categories';

    public static function descriptions() : array
    {
        return [
            static::CREATE_CATEGORIES => 'Создание категорий',
            static::VIEW_CATEGORIES => 'Просмотр категорий',
            static::EDIT_CATEGORIES => 'Редактирование категорий',
            static::DELETE_CATEGORIES => 'Удаление категорий',
        ];
    }
}
