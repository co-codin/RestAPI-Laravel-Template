<?php

namespace Modules\Seo\Enums;

use Modules\Role\Contracts\PermissionEnum;

class CanonicalPermission implements PermissionEnum
{
    const CREATE_CANONICALS = 'create canonicals';
    const VIEW_CANONICALS = 'view canonicals';
    const EDIT_CANONICALS = 'edit canonicals';
    const DELETE_CANONICALS = 'delete canonicals';

    public static function module(): string
    {
        return 'Канонические адреса';
    }

    public static function descriptions() : array
    {
        return [
            static::CREATE_CANONICALS => 'Добавление канонических ссылок',
            static::VIEW_CANONICALS => 'Просмотр канонических ссылок',
            static::EDIT_CANONICALS => 'Редактирование канонических ссылок',
            static::DELETE_CANONICALS => 'Удаление канонических ссылок',
        ];
    }
}
