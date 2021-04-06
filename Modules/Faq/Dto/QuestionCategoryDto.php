<?php


namespace Modules\Faq\Dto;


use App\Dto\Dto;

class QuestionCategoryDto extends Dto
{
    public ?string $name;

    public ?string $slug;

    public ?int $status;
}
