<?php

namespace Modules\Brand\Dto;

use App\Dto\BaseDto;
use Illuminate\Http\UploadedFile;

class BrandDto extends BaseDto
{
    public ?string $name;

    public ?string $slug;

    public ?UploadedFile $image;

    public ?string $website;

    public ?string $full_description;

    public mixed $status;

    public mixed $is_in_home = 0;

    public ?int $position;

    public ?string $country;

    public ?string $short_description;
}
