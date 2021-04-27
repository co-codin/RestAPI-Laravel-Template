<?php

namespace Modules\Product\Dto;

use App\Dto\Dto;
use Illuminate\Http\UploadedFile;

class ProductDto extends Dto
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
}
