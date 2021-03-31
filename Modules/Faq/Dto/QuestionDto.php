<?php


namespace Modules\Faq\Dto;


use App\Dto\Dto;

class QuestionDto extends Dto
{
    public string $question;

    public string $answer;

    public $status;

    public int $question_category_id;
}
