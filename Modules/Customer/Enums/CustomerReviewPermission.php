<?php

namespace Modules\Customer\Enums;

use App\Enums\BaseEnum;

class CustomerReviewPermission extends BaseEnum
{
    const CREATE_CUSTOMERS = 'create customer reviews';
    const VIEW_CUSTOMERS = 'view customer reviews';
    const EDIT_CUSTOMERS = 'edit customer reviews';
    const DELETE_CUSTOMERS = 'delete customer reviews';

    public static function descriptions() : array
    {
        return [
            static::CREATE_CUSTOMERS => 'Создание отзывов',
            static::VIEW_CUSTOMERS => 'Просмотр отзывов',
            static::EDIT_CUSTOMERS => 'Редактирование отзывов',
            static::DELETE_CUSTOMERS => 'Удаление отзывов',
        ];
    }
}
