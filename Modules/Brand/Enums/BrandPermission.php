<?php

namespace Modules\Brand\Enums;

use App\Enums\BaseEnum;

class BrandPermission extends BaseEnum
{
    const CREATE_BRANDS = 'create brands';
    const VIEW_BRANDS = 'view brands';
    const EDIT_BRANDS = 'edit brands';
    const DELETE_BRANDS = 'delete brands';

    public static function descriptions() : array
    {
        return [
            static::CREATE_BRANDS => 'Создание производителей',
            static::VIEW_BRANDS => 'Просмотр производителей',
            static::EDIT_BRANDS => 'Редактирование производителей',
            static::DELETE_BRANDS => 'Удаление производителей',
        ];
    }
}
