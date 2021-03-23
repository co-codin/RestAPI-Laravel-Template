<?php

namespace Modules\Brand\Dto;

use App\Dto\Dto;

class BrandDto extends Dto
{
    public string|null $name;

    public string|null $slug;

    public string|null $image;

    public string|null $website;

    public string|null $full_description;

    public int|null $status;

    public int|null $is_in_home;

    public int|null $position;

    public string|null $country;

    public string|null $short_description;
}
