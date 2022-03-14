<?php

namespace Modules\Filter\Dto;

use App\Dto\BaseDto;

class FilterDto extends BaseDto
{
    public ?string $name;

    public ?string $slug;

    public ?int $type;

    public ?int $category_id;

    public $is_enabled;

    public $is_default;

    public ?string $description;

    public ?array $options;

    public ?array $facet;

    public $is_system;

    public $is_hide_links_from_code;
}
