<?php

namespace Modules\Case\Enums;

use Modules\Role\Contracts\PermissionEnum;

class CasePermission implements PermissionEnum
{
    const CREATE_CASES = 'create cases';
    const VIEW_CASES = 'view cases';
    const EDIT_CASES = 'edit cases';
    const DELETE_CASES = 'delete cases';

    public static function module(): string
    {
        return 'Кейсы';
    }

    public static function descriptions() : array
    {
        return [
            static::CREATE_CASES => 'Добавление кейсов',
            static::VIEW_CASES => 'Просмотр кейсов',
            static::EDIT_CASES => 'Редактирование кейсов',
            static::DELETE_CASES => 'Удаление кейсов',
        ];
    }
}
