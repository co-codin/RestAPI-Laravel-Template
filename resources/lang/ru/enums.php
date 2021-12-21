<?php

use App\Enums\Status;
use App\Enums\DocumentSourceEnum;
use App\Enums\DocumentTypeEnum;
use App\Enums\Subject;

return [
    Status::class => [
        Status::ACTIVE => 'Отображается на сайте',
        Status::INACTIVE => 'Скрыто',
        Status::ONLY_URL => 'Доступно только по URL',
    ],
    DocumentSourceEnum::class => [
        DocumentSourceEnum::FILE => 'Файл',
        DocumentSourceEnum::LINK => 'Ссылка',
    ],

    DocumentTypeEnum::class => [
        DocumentTypeEnum::BOOKLET => 'Брошюра',
        DocumentTypeEnum::CERTIFICATE_RU => 'Регистрационное удостоверение',
        DocumentTypeEnum::CERTIFICATE_DS => 'Сертификат ДС',
        DocumentTypeEnum::TECHNICAL_PROPERTIES => 'Технические характеристики',
        DocumentTypeEnum::INSTRUCTION => 'Инструкция',
        DocumentTypeEnum::CATALOG => 'Каталог',
        DocumentTypeEnum::STANDARD_CATEGORIES => 'Стандарты оснащения',
    ],

    Subject::class => [
        Subject::OOO => 'ООО',
        Subject::IP => 'ИП',
        Subject::PHYSIC => 'Физик',
        Subject::ZAO => 'ЗАО',
        Subject::PAO => 'ПАО',
        Subject::OAO => 'ОАО',
        Subject::AO => 'АО',
        Subject::GUP => 'ГУП',
        Subject::CXPK => 'CXPK',
    ],
];
