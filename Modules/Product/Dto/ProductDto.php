<?php

namespace Modules\Product\Dto;

use App\Dto\BaseDto;
use App\Enums\Status;
use Illuminate\Http\UploadedFile;

class ProductDto extends BaseDto
{
    public ?array $categories;

    public $brand_id;

    public ?string $name;

    public ?string $slug;

    public ?UploadedFile $image;

    public ?string $short_description;

    public ?string $full_description;

    public ?int $warranty;

    public ?int $status = Status::INACTIVE;

    public $is_in_home = false;

    public ?array $documents;

    public ?array $peculiarities;

    public ?int $assigned_by_id;

    public ?string $stock_type;

    public ?UploadedFile $booklet;

    public ?string $video;
}
