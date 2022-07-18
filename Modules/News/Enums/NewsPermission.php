<?php

namespace Modules\News\Enums;

use App\Enums\BaseEnum;

class NewsPermission extends BaseEnum
{
    const CREATE_NEWS = 'create brands';
    const VIEW_NEWS = 'view brands';
    const EDIT_NEWS = 'edit brands';
    const DELETE_NEWS = 'delete brands';

    public static function descriptions() : array
    {
        return [
            static::CREATE_BRANDS => 'Создание производителей',
            static::VIEW_BRANDS => 'Просмотр производителей',
            static::EDIT_BRANDS => 'Редактирование производителей',
            static::DELETE_BRANDS => 'Удаление производителей',
        ];
    }
}
