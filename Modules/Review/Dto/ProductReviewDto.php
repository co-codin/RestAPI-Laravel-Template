<?php

namespace Modules\Review\Dto;

use App\Dto\BaseDto;

class ProductReviewDto extends BaseDto
{
    public ?int $product_id;

    public ?int $client_id;

    public ?string $first_name;

    public ?string $last_name;

    public ?int $experience;

    public ?string $advantages;

    public ?string $disadvantages;

    public ?string $comment;

    public ?int $status;

    public ?int $is_confirmed;

    public ?array $ratings;

    public ?int $like;

    public ?int $dislike;

    public ?string $created_at;

    public ?string $answered_at;
}
