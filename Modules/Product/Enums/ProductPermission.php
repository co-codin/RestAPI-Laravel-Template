<?php

namespace Modules\Product\Enums;

use App\Enums\BaseEnum;

class ProductPermission extends BaseEnum
{
    const CREATE_PRODUCTS = 'create products';
    const VIEW_PRODUCTS = 'view products';
    const EDIT_PRODUCTS = 'edit products';
    const DELETE_PRODUCTS = 'delete products';

    public static function descriptions() : array
    {
        return [
            static::CREATE_PRODUCTS => 'Создание товаров',
            static::VIEW_PRODUCTS => 'Просмотр товаров',
            static::EDIT_PRODUCTS => 'Редактирование товаров',
            static::DELETE_PRODUCTS => 'Удаление товаров',
        ];
    }
}
