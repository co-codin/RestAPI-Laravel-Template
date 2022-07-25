<?php

namespace Modules\Product\Enums;


use Modules\Role\Contracts\PermissionEnum;

class ProductAnswerPermission implements PermissionEnum
{
    const CREATE_PRODUCT_ANSWERS = 'create product answers';
    const VIEW_PRODUCT_ANSWERS = 'view product answers';
    const EDIT_PRODUCT_ANSWERS = 'edit product answers';
    const DELETE_PRODUCT_ANSWERS = 'delete product answers';

    public static function descriptions() : array
    {
        return [
            static::CREATE_PRODUCT_ANSWERS => 'Создание ответов товаров',
            static::VIEW_PRODUCT_ANSWERS => 'Просмотр ответов товаров',
            static::EDIT_PRODUCT_ANSWERS => 'Редактирование ответов товаров',
            static::DELETE_PRODUCT_ANSWERS => 'Удаление ответов товаров',
        ];
    }
}
