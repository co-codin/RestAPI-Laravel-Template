<?php

use Modules\Product\Enums\Availability;
use Modules\Product\Enums\DocumentSource;
use Modules\Product\Enums\DocumentType;
use Modules\Product\Enums\ProductQuestionStatus;
use Modules\Product\Enums\ProductVariationCondition;
use Modules\Product\Enums\ProductGroup;

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
    ],

    Availability::class => [
        Availability::IN_STOCK => 'В наличии',
        Availability::UNDER_THE_ORDER => 'Под заказ',
        Availability::COMING_SOON => 'Ожидается поступление',
        Availability::OUT_OF_PRODUCTION => 'Снят с производства',
        Availability::MISSING_REG_CERTIFICATE => 'Отсутствует регистрационное удостоверение',
    ],

    ProductGroup::class => [
        ProductGroup::PRIORITY => 'Приоритет продаж',
        ProductGroup::REORIENTATED => 'Переориентация продаж',
        ProductGroup::SIMPLIFIED => 'Упрощенная продажа',
        ProductGroup::IMPOSSIBLE => 'Невозможные к продаже',
    ],

    ProductQuestionStatus::class => [
        ProductQuestionStatus::IN_MODERATION => 'На рассмотрении',
        ProductQuestionStatus::APPROVED => 'Одобрен',
        ProductQuestionStatus::REJECTED => 'Отклонен',
    ],
];
