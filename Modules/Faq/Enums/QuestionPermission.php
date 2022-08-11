<?php

namespace Modules\Faq\Enums;

use Modules\Role\Contracts\PermissionEnum;

class QuestionPermission implements PermissionEnum
{
    const CREATE_QUESTIONS = 'create questions';
    const VIEW_QUESTIONS = 'view questions';
    const EDIT_QUESTIONS = 'edit questions';
    const DELETE_QUESTIONS = 'delete questions';
    const SORT_QUESTIONS = 'sort questions';

    public static function module(): string
    {
        return 'Вопросы и ответы';
    }

    public static function descriptions() : array
    {
        return [
            static::CREATE_QUESTIONS => 'Добавление вопросов',
            static::VIEW_QUESTIONS => 'Просмотр вопросов',
            static::EDIT_QUESTIONS => 'Редактирование вопросов',
            static::DELETE_QUESTIONS => 'Удаление вопросов',
            static::SORT_QUESTIONS => 'Сортировка вопросов',
        ];
    }
}
