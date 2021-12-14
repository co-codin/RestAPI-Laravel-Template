<?php

namespace Modules\Qna\Dto;

use App\Dto\BaseDto;

class ProductQuestionDto extends BaseDto
{
    public ?int $product_id;

    public ?int $client_id;

    public ?int $status;

    public ?string $text;

    public ?string $created_at;
}
