<?php

namespace Modules\Redirect\Enums;

use Modules\Role\Contracts\PermissionEnum;

class RedirectPermission implements PermissionEnum
{
    const CREATE_REDIRECTS = 'create redirects';
    const VIEW_REDIRECTS = 'view redirects';
    const EDIT_REDIRECTS = 'edit redirects';
    const DELETE_REDIRECTS = 'delete redirects';

    public static function descriptions() : array
    {
        return [
            static::CREATE_REDIRECTS => 'Создание редиректов',
            static::VIEW_REDIRECTS => 'Просмотр редиректов',
            static::EDIT_REDIRECTS => 'Редактирование редиректов',
            static::DELETE_REDIRECTS => 'Удаление редиректов',
        ];
    }
}
