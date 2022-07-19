<?php

namespace Modules\News\Enums;

use App\Enums\BaseEnum;

class NewsPermission extends BaseEnum
{
    const CREATE_NEWS = 'create news';
    const VIEW_NEWS = 'view news';
    const EDIT_NEWS = 'edit news';
    const DELETE_NEWS = 'delete news';

    public static function descriptions() : array
    {
        return [
            static::CREATE_NEWS => 'Создание новостей',
            static::VIEW_NEWS => 'Просмотр новостей',
            static::EDIT_NEWS => 'Редактирование новостей',
            static::DELETE_NEWS => 'Удаление новостей',
        ];
    }
}
