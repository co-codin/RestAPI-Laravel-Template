<?php

use Modules\Activity\Enums\ActivityAction;
use Modules\Activity\Enums\SubjectType;

return [
    ActivityAction::class => [
        ActivityAction::CREATED => 'Создание',
        ActivityAction::UPDATED => 'Редактирование',
        ActivityAction::DELETED => 'Удаление',
    ],

    SubjectType::class => [
        SubjectType::PRODUCT => 'Товар',
        SubjectType::REDIRECT => 'Редирект',
        SubjectType::BRAND => 'Производитель',
        SubjectType::CATEGORY => 'Категория',
        SubjectType::PROPERTY => 'Характеристика',
        SubjectType::SEO_RULE => 'SEO-правило',
        SubjectType::NEWS => 'Новость',
        SubjectType::FILTER => 'Фильтр',
        SubjectType::CASE_MODEL => 'Кейс',
        SubjectType::CABINET => 'Кабинет'
    ],
];
