<?php

namespace Modules\Cabinet\Enums;

use Modules\Role\Contracts\PermissionEnum;

class CabinetPermission implements PermissionEnum
{
    const CREATE_CABINETS = 'create cabinets';
    const VIEW_CABINETS = 'view cabinets';
    const EDIT_CABINETS = 'edit cabinets';
    const DELETE_CABINETS = 'delete cabinets';

    public static function descriptions() : array
    {
        return [
            static::CREATE_CABINETS => 'Создание кабинетов',
            static::VIEW_CABINETS => 'Просмотр кабинетов',
            static::EDIT_CABINETS => 'Редактирование кабинетов',
            static::DELETE_CABINETS => 'Удаление кабинетов',
        ];
    }
}
