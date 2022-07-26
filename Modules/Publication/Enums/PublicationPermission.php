<?php

namespace Modules\Publication\Enums;

use Modules\Role\Contracts\PermissionEnum;

class PublicationPermission implements PermissionEnum
{
    const CREATE_PUBLICATIONS = 'create publications';
    const VIEW_PUBLICATIONS = 'view publications';
    const EDIT_PUBLICATIONS = 'edit publications';
    const DELETE_PUBLICATIONS = 'delete publications';

    public static function module() : string
    {
        return 'Публикации';
    }

    public static function descriptions() : array
    {
        return [
            static::CREATE_PUBLICATIONS => 'Добавление публикаций',
            static::VIEW_PUBLICATIONS => 'Просмотр публикаций',
            static::EDIT_PUBLICATIONS => 'Редактирование публикаций',
            static::DELETE_PUBLICATIONS => 'Удаление публикаций',
        ];
    }
}
