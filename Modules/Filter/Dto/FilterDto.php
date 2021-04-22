<?php

namespace Modules\Filter\Dto;

use App\Dto\Dto;

class FilterDto extends Dto
{
    public ?string $name;

    public ?string $slug;

    public $property_id;

    public $type;

    public $category_id;

    public $is_enabled;

    public $is_default;

    public ?string $description;

    public ?array $options;
}
