<?php

namespace Modules\Review\Enums;

use Modules\Role\Contracts\PermissionEnum;

class ProductReviewPermission implements PermissionEnum
{
    const CREATE_PRODUCT_REVIEWS = 'create product reviews';
    const VIEW_PRODUCT_REVIEWS = 'view product reviews';
    const EDIT_PRODUCT_REVIEWS = 'edit product reviews';
    const DELETE_PRODUCT_REVIEWS = 'delete product reviews';
    const APPROVE_PRODUCT_REVIEWS = 'approve product reviews';
    const REJECT_PRODUCT_REVIEWS = 'reject product reviews';

    public static function descriptions() : array
    {
        return [
            static::CREATE_PRODUCT_REVIEWS => 'Создание отзывов товаров',
            static::VIEW_PRODUCT_REVIEWS => 'Просмотр отзывов товаров',
            static::EDIT_PRODUCT_REVIEWS => 'Редактирование отзывов товаров',
            static::DELETE_PRODUCT_REVIEWS => 'Удаление отзывов товаров',
            static::APPROVE_PRODUCT_REVIEWS => 'Принять отзывов товаров',
            static::REJECT_PRODUCT_REVIEWS => 'Отказать отзывов товаров',
        ];
    }
}
