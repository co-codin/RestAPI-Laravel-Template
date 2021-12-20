<?php

namespace Modules\Cabinet\Dto;

use App\Dto\BaseDto;
use Illuminate\Http\UploadedFile;

class CabinetDto extends BaseDto
{
    public ?int $category_id;

    public ?string $name;

    public ?string $slug;

    public ?UploadedFile $image;

    public $is_image_changed;

    public ?string $full_description;

    public ?int $status;

    public ?string $welcome_text;

    public ?array $requirements;

    public ?array $categories;
}
