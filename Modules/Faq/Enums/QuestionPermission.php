<?php

namespace Modules\Faq\Enums;

use App\Enums\BaseEnum;

class QuestionPermission extends BaseEnum
{
    const CREATE_QUESTIONS = 'create questions';
    const VIEW_QUESTIONS = 'view questions';
    const EDIT_QUESTIONS = 'edit questions';
    const DELETE_QUESTIONS = 'delete questions';
    const SORT_QUESTIONS = 'sort questions';

    public static function descriptions() : array
    {
        return [
            static::CREATE_QUESTIONS => 'Создание вопросов',
            static::VIEW_QUESTIONS => 'Просмотр вопросов',
            static::EDIT_QUESTIONS => 'Редактирование вопросов',
            static::DELETE_QUESTIONS => 'Удаление вопросов',
            static::SORT_QUESTIONS => 'Сортировка вопросов',
        ];
    }
}
