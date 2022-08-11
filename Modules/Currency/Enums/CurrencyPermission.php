<?php

namespace Modules\Currency\Enums;


use Modules\Role\Contracts\PermissionEnum;

class CurrencyPermission implements PermissionEnum
{
    const CREATE_CURRENCIES = 'create currencies';
    const VIEW_CURRENCIES = 'view currencies';
    const EDIT_CURRENCIES = 'edit currencies';
    const DELETE_CURRENCIES = 'delete currencies';

    public static function module(): string
    {
        return 'Валюты';
    }

    public static function descriptions() : array
    {
        return [
            static::CREATE_CURRENCIES => 'Добавление валют',
            static::VIEW_CURRENCIES => 'Просмотр валют',
            static::EDIT_CURRENCIES => 'Редактирование валют',
            static::DELETE_CURRENCIES => 'Удаление валют',
        ];
    }
}
