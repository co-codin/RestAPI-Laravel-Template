<?php

use App\Enums\Status;
use App\Enums\DocumentSourceEnum;
use App\Enums\DocumentTypeEnum;

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
        DocumentTypeEnum::CERTIFICATE_RU => 'Сертификат РУ',
        DocumentTypeEnum::CERTIFICATE_DS => 'Сертификат ДС',
        DocumentTypeEnum::TECHNICAL_PROPERTIES => 'Технические характеристики',
        DocumentTypeEnum::INSTRUCTION => 'Инструкция',
        DocumentTypeEnum::CATALOG => 'Каталог',
        DocumentTypeEnum::STANDARD_CATEGORIES => 'Стандарты оснащения',
    ],
];
