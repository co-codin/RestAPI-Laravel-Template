<?php

namespace Modules\Filter\Dto;

use App\Dto\Dto;

class FilterDto extends Dto
{
    public ?string $name;

    public ?string $slug;

    public ?int $property_id;

    public ?int $type;

    public ?int $category_id;

    public $is_enabled;

    public $is_default;

    public ?string $description;

    public ?array $options;
}
