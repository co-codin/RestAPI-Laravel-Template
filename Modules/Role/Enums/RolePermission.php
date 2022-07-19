<?php

namespace Modules\Role\Enums;

use App\Enums\BaseEnum;

final class RolePermission extends BaseEnum
{
    const CREATE_ROLES = 'create roles';
    const VIEW_ROLES = 'view roles';
    const EDIT_ROLES = 'edit roles';
    const DELETE_ROLES = 'delete roles';

    public static function descriptions() : array
    {
        return [
            static::CREATE_ROLES => 'Создание ролей',
            static::VIEW_ROLES => 'Просмотр ролей',
            static::EDIT_ROLES => 'Редактирование ролей',
            static::DELETE_ROLES => 'Удаление ролей',
        ];
    }
}
