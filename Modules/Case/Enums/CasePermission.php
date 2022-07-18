<?php

namespace Modules\Case\Enums;

use App\Enums\BaseEnum;

class CasePermission extends BaseEnum
{
    const CREATE_CASES = 'create cases';
    const VIEW_CASES = 'view cases';
    const EDIT_CASES = 'edit cases';
    const DELETE_CASES = 'delete cases';

    public static function descriptions() : array
    {
        return [
            static::CREATE_CASES => 'Создание кейсов',
            static::VIEW_CASES => 'Просмотр кейсов',
            static::EDIT_CASES => 'Редактирование кейсов',
            static::DELETE_CASES => 'Удаление кейсов',
        ];
    }
}
