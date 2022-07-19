<?php

namespace Modules\Vacancy\Enums;

use App\Enums\BaseEnum;

class VacancyPermission extends BaseEnum
{
    const CREATE_VACANCIES = 'create vacancies';
    const VIEW_VACANCIES = 'view vacancies';
    const EDIT_VACANCIES = 'edit vacancies';
    const DELETE_VACANCIES = 'delete vacancies';

    public static function descriptions() : array
    {
        return [
            static::CREATE_VACANCIES => 'Создание вакансий',
            static::VIEW_VACANCIES => 'Просмотр вакансий',
            static::EDIT_VACANCIES => 'Редактирование вакансий',
            static::DELETE_VACANCIES => 'Удаление вакансий',
        ];
    }
}
