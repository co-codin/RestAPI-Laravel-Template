<?php


namespace Modules\Faq\Dto;


use App\Dto\BaseDto;

class QuestionCategoryDto extends BaseDto
{
    public ?string $name;

    public ?string $slug;

    public ?int $status;

    public ?int $position;
}
