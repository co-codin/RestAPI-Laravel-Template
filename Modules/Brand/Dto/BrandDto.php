<?php

namespace Modules\Brand\Dto;

use App\Dto\BaseDto;
use Illuminate\Http\UploadedFile;

class BrandDto extends BaseDto
{
    public ?string $name;

    public ?string $slug;

    public UploadedFile|string|null $image;

    public ?string $website;

    public ?string $full_description;

    public $status;

    public $is_in_home = 0;

    public ?int $position;

    public ?int $country_id;

    public ?string $short_description;

    public ?int $assigned_by_id;
}
