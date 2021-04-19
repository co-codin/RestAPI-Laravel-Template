<?php


namespace Modules\Property\Dto;


use App\Dto\Dto;

/**
 * Class PropertyDto
 * @package Modules\Property\Dto\Admin
 */
class PropertyDto extends Dto
{
    public ?string $name;

    public $type;

    public ?string $options;

    public ?array $categories;

    public ?string $description;

    public $is_hidden_from_product;

    public $is_hidden_from_comparison;
}
