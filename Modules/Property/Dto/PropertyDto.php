<?php


namespace Modules\Property\Dto;


use App\Dto\BaseDto;

/**
 * Class PropertyDto
 * @package Modules\Property\Dto\Admin
 */
class PropertyDto extends BaseDto
{
    public ?string $name;

    public $type;

    public ?array $options;

    public ?array $categories;

    public ?string $description;

    public $is_hidden_from_product;

    public $is_hidden_from_comparison;

    public ?int $assigned_by_id;
}
