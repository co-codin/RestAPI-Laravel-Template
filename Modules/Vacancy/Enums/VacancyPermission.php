<?php

namespace Modules\Vacancy\Enums;

use Modules\Role\Contracts\PermissionEnum;

class VacancyPermission implements PermissionEnum
{
    const CREATE_VACANCIES = 'create vacancies';
    const VIEW_VACANCIES = 'view vacancies';
    const EDIT_VACANCIES = 'edit vacancies';
    const DELETE_VACANCIES = 'delete vacancies';

    public static function module(): string
    {
        return 'Вакансии';
    }

    public static function descriptions() : array
    {
        return [
            static::CREATE_VACANCIES => 'Добавление вакансий',
            static::VIEW_VACANCIES => 'Просмотр вакансий',
            static::EDIT_VACANCIES => 'Редактирование вакансий',
            static::DELETE_VACANCIES => 'Удаление вакансий',
        ];
    }
}
