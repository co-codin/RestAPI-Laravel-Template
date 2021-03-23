<?php

namespace Modules\Brand\Dto;

use App\Dto\Dto;

class BrandDto extends Dto
{
    public ?string $name;

    public ?string $slug;

    public ?string $image;

    public ?string $website;

    public ?string $full_description;

    public ?int $status;

    public ?int $is_in_home;

    public ?int $position;

    public ?string $country;

    public ?string $short_description;
}
