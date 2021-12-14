<?php

namespace Modules\Qna\Dto;

use App\Dto\BaseDto;

class ProductAnswerDto extends BaseDto
{
    public ?int $question_id;

    public ?string $text;

    public ?string $first_name;

    public ?string $last_name;
    
    public ?string $person;

    public ?int $like;

    public ?int $dislike;

    public ?string $created_at;
}
