<?php

use App\Enums\Status;
use App\Enums\DocumentTypeEnum;

return [
    Status::class => [
        Status::ACTIVE => 'Отображается на сайте',
        Status::INACTIVE => 'Скрыто',
        Status::ONLY_URL => 'Доступно только по URL',
    ],
    DocumentTypeEnum::class => [
        DocumentTypeEnum::FILE => 'Файл',
        DocumentTypeEnum::LINK => 'Ссылка',
    ],
];
