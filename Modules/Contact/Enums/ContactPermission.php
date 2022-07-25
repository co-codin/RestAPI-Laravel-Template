<?php

namespace Modules\Contact\Enums;

use Modules\Role\Contracts\PermissionEnum;

class ContactPermission implements PermissionEnum
{
    const CREATE_CONTACTS = 'create contacts';
    const VIEW_CONTACTS = 'view contacts';
    const EDIT_CONTACTS = 'edit contacts';
    const DELETE_CONTACTS = 'delete contacts';
    const SORT_CONTACTS = 'sort contacts';

    public static function descriptions() : array
    {
        return [
            static::CREATE_CONTACTS => 'Создание контактов',
            static::VIEW_CONTACTS => 'Просмотр контактов',
            static::EDIT_CONTACTS => 'Редактирование контактов',
            static::DELETE_CONTACTS => 'Удаление контактов',
            static::SORT_CONTACTS => 'Сортировка контактов',
        ];
    }
}
