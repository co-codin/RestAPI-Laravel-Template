<?php

namespace Modules\Export\Enum;

use App\Enums\BaseEnum;

class ExportPermission extends BaseEnum
{
    const CREATE_EXPORTS = 'create exports';
    const VIEW_EXPORTS = 'view exports';
    const EDIT_EXPORTS = 'edit exports';
    const DELETE_EXPORTS = 'delete exports';
    const EXPORT_EXPORTS = 'export exports';

    public static function descriptions() : array
    {
        return [
            static::CREATE_EXPORTS => 'Создание экспортов',
            static::VIEW_EXPORTS => 'Просмотр экспортов',
            static::EDIT_EXPORTS => 'Редактирование экспортов',
            static::DELETE_EXPORTS => 'Удаление экспортов',
            static::EXPORT_EXPORTS => 'Экспорт экспортов',
        ];
    }
}
