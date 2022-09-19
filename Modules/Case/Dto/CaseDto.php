<?php

namespace Modules\Case\Dto;

use App\Dto\BaseDto;
use App\Enums\Status;

class CaseDto extends BaseDto
{
    public ?int $city_id;

    public ?string $name;

    public ?string $slug;

    public ?string $short_description;

    public ?string $full_description;

    public ?string $body;

    public ?string $summary;

    public ?string $note;

    public ?string $image;

    public ?array $images;

    public ?string $published_at;

    public ?int $status = Status::INACTIVE;

    public ?array $products;

    public ?int $released_year;

    public ?int $released_quarter;
}
