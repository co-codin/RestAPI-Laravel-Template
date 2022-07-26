<?php

namespace Modules\Review\Enums;

use Modules\Role\Contracts\PermissionEnum;

class ProductReviewPermission implements PermissionEnum
{
    const CREATE_PRODUCT_REVIEWS = 'create product reviews';
    const VIEW_PRODUCT_REVIEWS = 'view product reviews';
    const EDIT_PRODUCT_REVIEWS = 'edit product reviews';
    const DELETE_PRODUCT_REVIEWS = 'delete product reviews';

    public static function module(): string
    {
        return 'Отзывы к товарам';
    }

    public static function descriptions() : array
    {
        return [
            static::CREATE_PRODUCT_REVIEWS => 'Добавление отзывов к товарам',
            static::VIEW_PRODUCT_REVIEWS => 'Просмотр отзывов к товарам',
            static::EDIT_PRODUCT_REVIEWS => 'Редактирование отзывов к товарам',
            static::DELETE_PRODUCT_REVIEWS => 'Удаление отзывов к товарам',
        ];
    }
}
