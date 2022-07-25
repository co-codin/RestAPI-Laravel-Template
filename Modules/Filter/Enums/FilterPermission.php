<?php

namespace Modules\Filter\Enums;

use Modules\Role\Contracts\PermissionEnum;

class FilterPermission implements PermissionEnum
{
    const CREATE_FILTERS = 'create filters';
    const VIEW_FILTERS = 'view filters';
    const EDIT_FILTERS = 'edit filters';
    const DELETE_FILTERS = 'delete filters';
    const SORT_FILTERS = 'sort filters';

    public static function descriptions() : array
    {
        return [
            static::CREATE_FILTERS => 'Создание фильтров',
            static::VIEW_FILTERS => 'Просмотр фильтров',
            static::EDIT_FILTERS => 'Редактирование фильтров',
            static::DELETE_FILTERS => 'Удаление фильтров',
            static::SORT_FILTERS => 'Сортировка фильтров',
        ];
    }
}
