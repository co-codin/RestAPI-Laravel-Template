<?php

namespace Modules\Product\Dto;

use App\Dto\BaseDto;
use Illuminate\Http\UploadedFile;

class ProductDto extends BaseDto
{
    public ?array $categories;

    public ?int $brand_id;

    public ?string $name;

    public ?string $slug;

    public ?UploadedFile $image;

    public ?string $short_description;

    public ?string $full_description;

    public ?int $warranty;

    public ?int $status;

    public $is_in_home;

    public ?array $documents;
}
