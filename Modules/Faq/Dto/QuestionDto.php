<?php

namespace Modules\Faq\Dto;

use App\Dto\BaseDto;

class QuestionDto extends BaseDto
{
    public ?string $question;

    public ?string $slug;

    public ?string $answer;

    public mixed $status;

    public mixed $question_category_id;
}
