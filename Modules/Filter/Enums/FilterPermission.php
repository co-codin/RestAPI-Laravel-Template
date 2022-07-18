<?php

namespace Modules\Filter\Enums;

use App\Enums\BaseEnum;

class FilterPermission extends BaseEnum
{
    const CREATE_FILTERS = 'create filters';
    const VIEW_FILTERS = 'view filters';
    const EDIT_FILTERS = 'edit filters';
    const DELETE_FILTERS = 'delete filters';

    public static function descriptions() : array
    {
        return [
            static::CREATE_FILTERS => 'Создание фильтров',
            static::VIEW_FILTERS => 'Просмотр фильтров',
            static::EDIT_FILTERS => 'Редактирование фильтров',
            static::DELETE_FILTERS => 'Удаление фильтров',
        ];
    }
}
