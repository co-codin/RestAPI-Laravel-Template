<?php

namespace Modules\Seo\Enums;

use App\Enums\BaseEnum;

class CanonicalPermission extends BaseEnum
{
    const CREATE_CANONICALS = 'create canonicals';
    const VIEW_CANONICALS = 'view canonicals';
    const EDIT_CANONICALS = 'edit canonicals';
    const DELETE_CANONICALS = 'delete canonicals';

    public static function descriptions() : array
    {
        return [
            static::CREATE_CANONICALS => 'Создание канонических',
            static::VIEW_CANONICALS => 'Просмотр канонических',
            static::EDIT_CANONICALS => 'Редактирование канонических',
            static::DELETE_CANONICALS => 'Удаление канонических',
        ];
    }
}
