<?php

use Modules\Product\Enums\DocumentSource;
use Modules\Product\Enums\DocumentType;

return [
    DocumentSource::class => [
        DocumentSource::URL => 'Ссылка',
        DocumentSource::FILE => 'Файл',
    ],
    DocumentType::class => [
        DocumentType::MANUAL => 'Руководство',
        DocumentType::CERTIFICATE_RU => 'Сертификат РУ',
        DocumentType::BROCHURE => 'Брошюра',
    ],
];
