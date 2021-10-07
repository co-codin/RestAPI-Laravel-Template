<?php

use Modules\Product\Enums\DocumentSource;
use Modules\Product\Enums\DocumentType;
use Modules\Product\Enums\ProductVariationCondition;

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
    ProductVariationCondition::class => [
        ProductVariationCondition::NEW => 'Новый',
        ProductVariationCondition::DEMO => 'Демонстрационный',
        ProductVariationCondition::RESTORED => 'Восстановленный',
        ProductVariationCondition::USED => 'Б/У',
    ]
];
