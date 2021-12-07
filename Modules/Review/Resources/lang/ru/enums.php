<?php


use Modules\Review\Enums\ProductReviewExperience;
use Modules\Review\Enums\ProductReviewStatus;

return [
    ProductReviewStatus::class => [
        ProductReviewStatus::IN_MODERATION => 'На рассмотрении',
        ProductReviewStatus::APPROVED => 'Одобрен',
        ProductReviewStatus::REJECTED => 'Отклонен',
    ],

    ProductReviewExperience::class => [
        ProductReviewExperience::LESS_MONTH => 'Меньше месяца',
        ProductReviewExperience::SEVERAL_MONTHS => 'Несколько месяцев',
        ProductReviewExperience::MORE_YEAR => 'Больше года',
    ],
];
