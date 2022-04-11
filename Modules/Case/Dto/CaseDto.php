<?php

namespace Modules\Case\Dto;

use App\Dto\BaseDto;

class CaseDto extends BaseDto
{
    public ?int $city_id;

    public ?string $name;

    public ?string $slug;

    public ?string $short_description;

    public ?string $full_description;

    public ?string $image;

    public ?string $published_at;

    public mixed $is_enabled = 1;
}
