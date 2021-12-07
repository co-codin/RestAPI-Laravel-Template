<?php

namespace Modules\Cabinet\Dto;

use App\Dto\BaseDto;
use Illuminate\Http\UploadedFile;

class CabinetDto extends BaseDto
{
    public ?string $name;

    public ?string $slug;

    public UploadedFile|string|null $image;

    public ?int $category_id;

    public ?string $full_description;

    public ?int $status;

    public ?string $welcome_text;

    public ?array $documents;

    public ?array $requirements;

    public ?array $categories;
}
