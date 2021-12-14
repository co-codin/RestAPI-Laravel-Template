<?php

use Modules\Qna\Enums\ProductQuestionStatus;

return [
    ProductQuestionStatus::class => [
        ProductQuestionStatus::IN_MODERATION => 'На рассмотрении',
        ProductQuestionStatus::APPROVED => 'Одобрен',
        ProductQuestionStatus::REJECTED => 'Отклонен',
    ],
];
