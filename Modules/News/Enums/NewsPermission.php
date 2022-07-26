<?php

namespace Modules\News\Enums;


use Modules\Role\Contracts\PermissionEnum;

class NewsPermission implements PermissionEnum
{
    const CREATE_NEWS = 'create news';
    const VIEW_NEWS = 'view news';
    const EDIT_NEWS = 'edit news';
    const DELETE_NEWS = 'delete news';

    public static function module(): string
    {
        return 'Новости';
    }

    public static function descriptions() : array
    {
        return [
            static::CREATE_NEWS => 'Добавление новостей',
            static::VIEW_NEWS => 'Просмотр новостей',
            static::EDIT_NEWS => 'Редактирование новостей',
            static::DELETE_NEWS => 'Удаление новостей',
        ];
    }
}
