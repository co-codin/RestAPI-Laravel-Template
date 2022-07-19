<?php

namespace Modules\Currency\Enums;

use App\Enums\BaseEnum;

class CurrencyPermission extends BaseEnum
{
    const CREATE_CURRENCIES = 'create currencies';
    const VIEW_CURRENCIES = 'view currencies';
    const EDIT_CURRENCIES = 'edit currencies';
    const DELETE_CURRENCIES = 'delete currencies';

    public static function descriptions() : array
    {
        return [
            static::CREATE_CURRENCIES => 'Создание валют',
            static::VIEW_CURRENCIES => 'Просмотр валют',
            static::EDIT_CURRENCIES => 'Редактирование валют',
            static::DELETE_CURRENCIES => 'Удаление валют',
        ];
    }
}
