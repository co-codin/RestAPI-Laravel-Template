<?php

namespace Modules\Product\Dto;

use App\Dto\BaseDto;

class ProductQuestionDto extends BaseDto
{
    public ?int $product_id;

    public ?int $client_id;

    public ?int $status;

    public ?string $text;

    public ?string $date;

    public ?string $first_name;

    public ?string $last_name;
}
