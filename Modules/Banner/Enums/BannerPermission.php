<?php

namespace Modules\Banner\Enums;


use Modules\Role\Contracts\PermissionEnum;

class BannerPermission implements PermissionEnum
{
    const CREATE_BANNERS = 'create banners';
    const VIEW_BANNERS = 'view banners';
    const EDIT_BANNERS = 'edit banners';
    const DELETE_BANNERS = 'delete banners';

    public static function module(): string
    {
        return 'Баннеры';
    }

    public static function descriptions() : array
    {
        return [
            static::CREATE_BANNERS => 'Добавление баннеров',
            static::VIEW_BANNERS => 'Просмотр баннеров',
            static::EDIT_BANNERS => 'Редактирование баннеров',
            static::DELETE_BANNERS => 'Удаление баннеров',
        ];
    }
}
