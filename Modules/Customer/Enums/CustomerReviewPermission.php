<?php

namespace Modules\Customer\Enums;

use App\Enums\BaseEnum;

class CustomerReviewPermission extends BaseEnum
{
    const CREATE_CUSTOMERS = 'create customers';
    const VIEW_CUSTOMERS = 'view customers';
    const EDIT_CUSTOMERS = 'edit customers';
    const DELETE_CUSTOMERS = 'delete customers';

    public static function descriptions() : array
    {
        return [
            static::CREATE_CUSTOMERS => 'Создание потребителей',
            static::VIEW_CUSTOMERS => 'Просмотр потребителей',
            static::EDIT_CUSTOMERS => 'Редактирование потребителей',
            static::DELETE_CUSTOMERS => 'Удаление потребителей',
        ];
    }
}
