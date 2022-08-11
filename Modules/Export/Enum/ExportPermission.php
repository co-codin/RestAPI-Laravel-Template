<?php

namespace Modules\Export\Enum;

use Modules\Role\Contracts\PermissionEnum;

class ExportPermission implements PermissionEnum
{
    const CREATE_EXPORTS = 'create exports';
    const VIEW_EXPORTS = 'view exports';
    const EDIT_EXPORTS = 'edit exports';
    const DELETE_EXPORTS = 'delete exports';
    const EXPORT_EXPORTS = 'export exports';

    public static function module(): string
    {
        return 'Экспорт товаров';
    }

    public static function descriptions() : array
    {
        return [
            static::CREATE_EXPORTS => 'Добавление фидов',
            static::VIEW_EXPORTS => 'Просмотр фидов',
            static::EDIT_EXPORTS => 'Редактирование фидов',
            static::DELETE_EXPORTS => 'Удаление фидов',
            static::EXPORT_EXPORTS => 'Ручная генерация фидов',
        ];
    }
}
