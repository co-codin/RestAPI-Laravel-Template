<?php

namespace Modules\Product\Enums;

use Modules\Role\Contracts\PermissionEnum;

class ProductQuestionPermission implements PermissionEnum
{
    const CREATE_PRODUCT_QUESTIONS = 'create product questions';
    const VIEW_PRODUCT_QUESTIONS = 'view product questions';
    const EDIT_PRODUCT_QUESTIONS = 'edit product questions';
    const DELETE_PRODUCT_QUESTIONS = 'delete product questions';

    public static function module(): string
    {
        return 'Вопросы к товарам';
    }

    public static function descriptions() : array
    {
        return [
            static::CREATE_PRODUCT_QUESTIONS => 'Добавление вопросов к товарам',
            static::VIEW_PRODUCT_QUESTIONS => 'Просмотр вопросов к товарам',
            static::EDIT_PRODUCT_QUESTIONS => 'Редактирование вопросов к товарам',
            static::DELETE_PRODUCT_QUESTIONS => 'Удаление вопросов к товарам',
        ];
    }
}
