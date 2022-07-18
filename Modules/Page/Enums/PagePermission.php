<?php

namespace Modules\Page\Enums;

use App\Enums\BaseEnum;

class PagePermission extends BaseEnum
{
    const CREATE_PAGES = 'create pages';
    const VIEW_PAGES = 'view pages';
    const EDIT_PAGES = 'edit pages';
    const DELETE_PAGES = 'delete pages';

    public static function descriptions() : array
    {
        return [
            static::CREATE_PAGES => 'Создание страниц',
            static::VIEW_PAGES => 'Просмотр страниц',
            static::EDIT_PAGES => 'Редактирование страниц',
            static::DELETE_PAGES => 'Удаление страниц',
        ];
    }
}
