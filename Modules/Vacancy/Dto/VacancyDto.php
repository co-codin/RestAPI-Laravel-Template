<?php


namespace Modules\Vacancy\Dto;


use App\Dto\BaseDto;

class VacancyDto extends BaseDto
{
    public ?string $name;

    public ?string $slug;

    public ?string $short_description;

    public ?string $full_description;

    public ?int $status;
}
