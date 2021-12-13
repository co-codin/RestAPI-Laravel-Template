<?php

namespace Modules\Qna\Dto;

use App\Dto\BaseDto;

class AnswerDto extends BaseDto
{
    public ?int $question_id;

    public ?string $text;

    public ?string $name;

    public ?int $like;

    public ?int $dislike;

    public ?string $created_at;
}
