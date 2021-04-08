<?php


namespace Modules\Faq\Dto;


use App\Dto\Dto;

class QuestionDto extends Dto
{
    public ?string $question;

    public ?string $slug;

    public ?string $answer;

    /** @var mixed */
    public $status;

    public ?int $question_category_id;
}
