<?php

namespace Modules\Contact\Enums;

use App\Enums\BaseEnum;

class ContactPermission extends BaseEnum
{
    const CREATE_BRANDS = 'create contacts';
    const VIEW_BRANDS = 'view contacts';
    const EDIT_BRANDS = 'edit contacts';
    const DELETE_BRANDS = 'delete contacts';

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
