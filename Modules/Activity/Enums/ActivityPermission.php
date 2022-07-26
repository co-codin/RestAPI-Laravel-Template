<?php


namespace Modules\Activity\Enums;


use Modules\Role\Contracts\PermissionEnum;

class ActivityPermission implements PermissionEnum
{
    const VIEW_ACTIVITY_LOG = 'view activity log';

    public static function module(): string
    {
        return 'Журнал событий';
    }

    public static function descriptions(): array
    {
        return [
            self::VIEW_ACTIVITY_LOG => 'Просмотр журнала событий',
        ];
    }
}
