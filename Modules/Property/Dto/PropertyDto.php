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

    public ?string $description;

    public $is_hidden_from_product;

    public $is_hidden_from_comparison;

    public $is_numeric;
}
