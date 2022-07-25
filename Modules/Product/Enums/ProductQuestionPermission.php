<?php

namespace Modules\Product\Enums;

use Modules\Role\Contracts\PermissionEnum;

class ProductQuestionPermission implements PermissionEnum
{
    const CREATE_PRODUCT_QUESTIONS = 'create product questions';
    const VIEW_PRODUCT_QUESTIONS = 'view product questions';
    const EDIT_PRODUCT_QUESTIONS = 'edit product questions';
    const DELETE_PRODUCT_QUESTIONS = 'delete product questions';
    const APPROVE_PRODUCT_QUESTIONS = 'approve product questions';
    const REJECT_PRODUCT_QUESTIONS = 'reject product questions';

    public static function descriptions() : array
    {
        return [
            static::CREATE_PRODUCT_QUESTIONS => 'Создание вопросов товаров',
            static::VIEW_PRODUCT_QUESTIONS => 'Просмотр вопросов товаров',
            static::EDIT_PRODUCT_QUESTIONS => 'Редактирование вопросов товаров',
            static::DELETE_PRODUCT_QUESTIONS => 'Удаление вопросов товаров',
            static::APPROVE_PRODUCT_QUESTIONS => 'Принять вопросов товаров',
            static::REJECT_PRODUCT_QUESTIONS => 'Отказать вопросов товаров',
        ];
    }
}
