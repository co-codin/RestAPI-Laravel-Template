<?php

namespace Modules\Achievement\Enums;

use Modules\Role\Contracts\PermissionEnum;

final class AchievementPermission implements PermissionEnum
{
    const CREATE_ACHIEVEMENTS = 'create achievements';
    const VIEW_ACHIEVEMENTS = 'view achievements';
    const EDIT_ACHIEVEMENTS = 'edit achievements';
    const DELETE_ACHIEVEMENTS = 'delete achievements';
    const SORT_ACHIEVEMENTS = 'sort achievements';

    public static function descriptions() : array
    {
        return [
            self::CREATE_ACHIEVEMENTS => 'Создание достижений',
            self::VIEW_ACHIEVEMENTS => 'Просмотр достижений',
            self::EDIT_ACHIEVEMENTS => 'Редактирование достижений',
            self::DELETE_ACHIEVEMENTS => 'Удаление достижений',
            self::SORT_ACHIEVEMENTS => 'Сортировка достижений',
        ];
    }
}
